<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Controller;

use App\Form\Generator\ProjectType;
use App\PHPDocker\Generator\Generator;
use App\PHPDocker\PhpExtension\AvailableExtensionsFactory;
use App\PHPDocker\Project\Project;
use App\PHPDocker\Project\ServiceOptions\Clickhouse;
use App\PHPDocker\Project\ServiceOptions\Elasticsearch;
use App\PHPDocker\Project\ServiceOptions\GlobalOptions;
use App\PHPDocker\Project\ServiceOptions\Mailhog;
use App\PHPDocker\Project\ServiceOptions\MariaDB;
use App\PHPDocker\Project\ServiceOptions\Memcached;
use App\PHPDocker\Project\ServiceOptions\MySQL;
use App\PHPDocker\Project\ServiceOptions\Nginx;
use App\PHPDocker\Project\ServiceOptions\Php as PhpOptions;
use App\PHPDocker\Project\ServiceOptions\Postgres;
use App\PHPDocker\Project\ServiceOptions\Redis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Docker environment generator controller.
 */
class GeneratorController extends AbstractController
{
    public function __construct(
        private readonly Generator $generator,
        private readonly string $environment,
    ) {
    }

    /**
     * Form and form processor for creating a project.
     */
    public function create(Request $request): BinaryFileResponse|Response
    {
        $form = $this->createForm(type: ProjectType::class, options: ['method' => Request::METHOD_POST]);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            /** @var array $data */
            $data = $form->getData();
            $project = $this->hydrateProject($data);

            // Generate zip file with docker project
            $zipFile = $this->generator->generate($project);

            // Generate file download & cleanup (keep file in test env so functional tests can read it)
            $response = new BinaryFileResponse($zipFile->getTmpFilename());
            $response
                ->prepare($request)
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipFile->getFilename());
            if ($this->environment !== 'test') {
                $response->deleteFileAfterSend(true);
            }

            return $response;
        }

        return $this->render('generator.html.twig', [
            'form'              => $form->createView(),
            'phpExtensionsJson' => json_encode(AvailableExtensionsFactory::getAllExtensionNames()),
        ]);
    }

    private function hydrateProject(array $formData): Project
    {
        $phpData = $formData['phpOptions'];

        $extensions = $phpData['phpExtensions'] ?? [];

        $phpOptions = new PhpOptions(
            version: $phpData['version'],
            extensions: $extensions,
            hasGit: $phpData['hasGit'],
            frontControllerPath: $phpData['frontControllerPath'],
        );

        $globalOptionsData = $formData['globalOptions'];
        $globalOptions     = new GlobalOptions(
            basePort: $globalOptionsData['basePort'],
            appPath: rtrim($globalOptionsData['appPath'], '/'),
            dockerWorkingDir: rtrim($globalOptionsData['dockerWorkingDir'], '/'),
        );

        $mysqlOptions = $formData['mysqlOptions']['hasMysql'] === true ? new MySQL(
            version: $formData['mysqlOptions']['version'],
            rootPassword: $formData['mysqlOptions']['rootPassword'],
            databaseName: $formData['mysqlOptions']['databaseName'],
            username: $formData['mysqlOptions']['username'],
            password: $formData['mysqlOptions']['password'],
            enabled: true,
        ) : null;

        $mariadbOptions = $formData['mariadbOptions']['hasMariadb'] === true ? new MariaDB(
            version: $formData['mariadbOptions']['version'],
            rootPassword: $formData['mariadbOptions']['rootPassword'],
            databaseName: $formData['mariadbOptions']['databaseName'],
            username: $formData['mariadbOptions']['username'],
            password: $formData['mariadbOptions']['password'],
            enabled: true,
        ) : null;

        $postgresOptions = $formData['postgresOptions']['hasPostgres'] === true ? new Postgres(
            version: (string) $formData['postgresOptions']['version'],
            rootUser: $formData['postgresOptions']['rootUser'],
            rootPassword: $formData['postgresOptions']['rootPassword'],
            databaseName: $formData['postgresOptions']['databaseName'],
            enabled: true,
        ) : null;

        $elasticsearchOptions = $formData['elasticsearchOptions']['hasElasticsearch'] === true ? new Elasticsearch(
            version: $formData['elasticsearchOptions']['version'],
            enabled: true,
        ) : null;

        return new Project(
            phpOptions: $phpOptions,
            globalOptions: $globalOptions,
            nginxOptions: new Nginx(),
            mysqlOptions: $mysqlOptions,
            mariadbOptions: $mariadbOptions,
            postgresOptions: $postgresOptions,
            memcachedOptions: new Memcached(enabled: $formData['hasMemcached']),
            redisOptions: new Redis(enabled: $formData['hasRedis']),
            mailhogOptions: new Mailhog(enabled: $formData['hasMailhog']),
            elasticsearchOptions: $elasticsearchOptions,
            clickhouseOptions: new Clickhouse(enabled: $formData['hasClickhouse']),
        );
    }
}

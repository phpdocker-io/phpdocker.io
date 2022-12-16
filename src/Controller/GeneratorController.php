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
use App\PHPDocker\Project\Project;
use App\PHPDocker\Project\ServiceOptions\GlobalOptions;
use App\PHPDocker\Project\ServiceOptions\Php as PhpOptions;
use InvalidArgumentException;
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
    public function __construct(private Generator $generator)
    {
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

            // Generate file download & cleanup
            $response = new BinaryFileResponse($zipFile->getTmpFilename());
            $response
                ->prepare($request)
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipFile->getFilename())
                ->deleteFileAfterSend(true);

            return $response;
        }

        return $this->render('generator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function hydrateProject(array $formData): Project
    {
        $phpData = $formData['phpOptions'];

        $extensions = match ($phpData['version']) {
            PhpOptions::PHP_VERSION_80 => $phpData['phpExtensions80'],
            PhpOptions::PHP_VERSION_81 => $phpData['phpExtensions81'],
            PhpOptions::PHP_VERSION_82 => $phpData['phpExtensions82'],
            default => throw new InvalidArgumentException(sprintf('Unsupported php version %s', $phpData['version'])),
        };

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

        $project = new Project(
            phpOptions: $phpOptions,
            globalOptions: $globalOptions,
        );

        $project->getMemcachedOptions()->setEnabled($formData['hasMemcached']);
        $project->getRedisOptions()->setEnabled($formData['hasRedis']);
        $project->getMailhogOptions()->setEnabled($formData['hasMailhog']);
        $project->getClickhouseOptions()->setEnabled($formData['hasClickhouse']);

        $mysqlData = $formData['mysqlOptions'];
        if ($mysqlData['hasMysql'] === true) {
            $project
                ->getMysqlOptions()
                ->setEnabled(true)
                ->setVersion($mysqlData['version'])
                ->setDatabaseName($mysqlData['databaseName'])
                ->setRootPassword($mysqlData['rootPassword'])
                ->setUsername($mysqlData['username'])
                ->setPassword($mysqlData['password']);
        }

        $mariaDbData = $formData['mariadbOptions'];
        if ($mariaDbData['hasMariadb'] === true) {
            $project
                ->getMariadbOptions()
                ->setEnabled(true)
                ->setVersion($mariaDbData['version'])
                ->setDatabaseName($mariaDbData['databaseName'])
                ->setRootPassword($mariaDbData['rootPassword'])
                ->setUsername($mariaDbData['username'])
                ->setPassword($mariaDbData['password']);
        }

        $pgData = $formData['postgresOptions'];
        if ($pgData['hasPostgres'] === true) {
            $project
                ->getPostgresOptions()
                ->setEnabled(true)
                ->setVersion($pgData['version'])
                ->setDatabaseName($pgData['databaseName'])
                ->setRootUser($pgData['rootUser'])
                ->setRootPassword($pgData['rootPassword']);
        }

        $esData = $formData['elasticsearchOptions'];
        if ($esData['hasElasticsearch'] === true) {
            $project
                ->getElasticsearchOptions()
                ->setEnabled(true)
                ->setVersion($esData['version']);
        }

        return $project;
    }
}

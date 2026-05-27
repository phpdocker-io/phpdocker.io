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
use App\PHPDocker\Project\ProjectFactory;
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
        private readonly ProjectFactory $projectFactory,
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
            $project = $this->projectFactory->fromFormData($data);

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
            'phpExtensionsJson' => json_encode(AvailableExtensionsFactory::getAllExtensionNames(), JSON_THROW_ON_ERROR),
        ]);
    }
}

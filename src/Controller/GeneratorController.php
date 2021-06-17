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

use App\Entity\Generator\PhpOptions;
use App\Entity\Generator\Project;
use App\Form\Generator\ProjectType;
use App\PHPDocker\Generator\Generator;
use App\PHPDocker\Interfaces\SlugifierInterface;
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
    /**
     * Form and form processor for creating a project.
     */
    public function create(
        Request $request,
        SlugifierInterface $slugifier,
        Generator $generator
    ): BinaryFileResponse|Response {
        // Set up form
        $project = new Project($slugifier);
        $form    = $this->createForm(ProjectType::class, $project, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            // Fix PHP extensions per version before sending to generator
            $project = $this->fixPhpExtensionGeneratorExpectation($project);

            // Generate zip file with docker project
            $zipFile = $generator->generate($project);

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

    /**
     * Add php extensions to project based on version on the property the generator expects
     * as phpExtensions56/70 do not exist from its point of view.
     *
     * @throws InvalidArgumentException
     */
    private function fixPhpExtensionGeneratorExpectation(Project $project): Project
    {
        /** @var PhpOptions $phpOptions */
        $phpOptions = $project->getPhpOptions();
        $phpVersion = $phpOptions->getVersion();

        $extensions = match ($phpVersion) {
            PhpOptions::PHP_VERSION_72 => $phpOptions->getPhpExtensions72(),
            PhpOptions::PHP_VERSION_73 => $phpOptions->getPhpExtensions73(),
            PhpOptions::PHP_VERSION_74 => $phpOptions->getPhpExtensions74(),
            PhpOptions::PHP_VERSION_80 => $phpOptions->getPhpExtensions80(),
            default => throw new InvalidArgumentException(sprintf('Eek! Unsupported php version %s', $phpVersion)),
        };

        $project->getPhpOptions()->setPhpExtensions($extensions);

        return $project;
    }
}

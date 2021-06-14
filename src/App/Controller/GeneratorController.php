<?php
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

use AppBundle\Entity\Generator\PhpOptions;
use AppBundle\Entity\Generator\Project;
use AppBundle\Form\Generator\ProjectType;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Docker environment generator controller.
 *
 * @package AppBundle\Controller
 * @author  Luis A. Pabon Flores
 */
class GeneratorController extends AbstractController
{
    /**
     * Form and form processor for creating a project.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|Response
     */
    public function createAction(Request $request)
    {
        // Set up form
        $project = new Project($this->container->get('slugifier'));
        $form    = $this->createForm(ProjectType::class, $project, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            // Fix PHP extensions per version before sending to generator
            $project = $this->fixPhpExtensionGeneratorExpectation($project);

            // Generate zip file with docker project
            $generator = $this->container->get('docker_generator');
            $zipFile   = $generator->generate($project);

            // Generate file download & cleanup
            $response = new BinaryFileResponse($zipFile->getTmpFilename());
            $response
                ->prepare($request)
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipFile->getFilename())
                ->deleteFileAfterSend(true);

            return $response;
        }

        return $this->render('AppBundle:Generator:generator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Add php extensions to project based on version on the property the generator expects
     * as phpExtensions56/70 do not exist from its point of view.
     *
     * @param Project $project
     *
     * @return Project
     * @throws InvalidArgumentException
     */
    private function fixPhpExtensionGeneratorExpectation(Project $project): Project
    {
        /** @var PhpOptions $phpOptions */
        $phpOptions = $project->getPhpOptions();
        $phpVersion = $phpOptions->getVersion();

        switch ($phpVersion) {
            case PhpOptions::PHP_VERSION_72:
                $extensions = $phpOptions->getPhpExtensions72();
                break;

            case PhpOptions::PHP_VERSION_73:
                $extensions = $phpOptions->getPhpExtensions73();
                break;

            case PhpOptions::PHP_VERSION_74:
                $extensions = $phpOptions->getPhpExtensions74();
                break;

            case PhpOptions::PHP_VERSION_80:
                $extensions = $phpOptions->getPhpExtensions80();
                break;

            default:
                throw new InvalidArgumentException(sprintf('Eek! Unsupported php version %s', $phpVersion));
        }

        $project->getPhpOptions()->setPhpExtensions($extensions);

        return $project;
    }
}

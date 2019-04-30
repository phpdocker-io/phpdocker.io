<?php
/**
 * Copyright 2019 Luis Alberto Pabón Flores
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
 *
 */

namespace App\Controller;

use App\Generator\Entity\Project;
use App\Generator\Form\ProjectType;
use Limenius\Liform\Liform;
use PHPDocker\Generator\Generator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class GeneratorController
{
    /**
     * @var Liform
     */
    private $liform;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Liform $liform, FormFactoryInterface $formFactory, Generator $generator)
    {
        $this->liform      = $liform;
        $this->formFactory = $formFactory;
        $this->generator   = $generator;
    }

    public function getGeneratorOptions(): JsonResponse
    {
        $schema = $this->liform->transform($this->formFactory->create(ProjectType::class));

        return new JsonResponse($schema);
    }

    public function generate(Request $request): Response
    {
        $project = new Project();
        $form    = $this->formFactory->create(ProjectType::class, $project, ['csrf_protection' => false]);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);

        dump($project);

        if ($form->isValid() === true) {
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

        return new JsonResponse(['errors' => $form->getErrors()], 400);
    }
}

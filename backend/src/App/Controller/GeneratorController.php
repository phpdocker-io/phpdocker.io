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

use App\Generator\Form\ProjectType;
use Limenius\Liform\Liform;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function __construct(Liform $liform, FormFactoryInterface $formFactory)
    {
        $this->liform      = $liform;
        $this->formFactory = $formFactory;
    }

    public function getGeneratorOptions(): JsonResponse
    {
        $schema = $this->liform->transform($this->formFactory->create(ProjectType::class));

        return new JsonResponse($schema);
    }
}

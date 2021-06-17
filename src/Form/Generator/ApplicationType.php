<?php
declare(strict_types=1);
/**
 * Copyright 2016 Luis Alberto Pabón Flores
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

namespace App\Form\Generator;

use App\Assert\ApplicationType as AssertApplicationType;
use App\PHPDocker\Project\ServiceOptions\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Form for application options.
 */
class ApplicationType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('applicationType', ChoiceType::class, [
                'choices'     => array_flip(Application::getChoices()),
                'expanded'    => false,
                'multiple'    => false,
                'label'       => 'Application type',
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new AssertApplicationType(),
                ],
            ])
            ->add('uploadSize', IntegerType::class, [
                'label'       => 'Max upload size (MB)',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Type(type: 'integer'),
                    new Range(min: 2, max: 2147483647),
                ],
            ]);
    }
}

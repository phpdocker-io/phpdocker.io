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

use App\PHPDocker\PhpExtension\Php74AvailableExtensions;
use App\PHPDocker\PhpExtension\Php80AvailableExtensions;
use App\PHPDocker\PhpExtension\Php81AvailableExtensions;
use App\PHPDocker\PhpExtension\PhpExtension;
use App\PHPDocker\Project\ServiceOptions\Php;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Form for PHP options.
 */
class PhpType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $phpOptionsConstraints = [
            new Type(type: 'array'),
            new All([
                new Type(type: 'string'),
            ]),
        ];

        $builder
            ->add('frontControllerPath', TextType::class, [
                'label'       => 'Front controller path (relative to container workdir)',
                'attr'        => ['placeholder' => 'Password for root user'],
                'data'        => 'public/index.php',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 2, max: 128),
                ],
            ])
            ->add('hasGit', CheckboxType::class, [
                'label'    => 'Add git (eg for composer) - Adds 75MB',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'     => $this->getVersionChoices(),
                'expanded'    => false,
                'multiple'    => false,
                'label'       => 'PHP Version',
                'empty_data'  => Php::getSupportedVersions()[0],
                'constraints' => [
                    new NotBlank(),
                    new Choice(choices: Php::getSupportedVersions()),
                ],
            ])
            ->add('phpExtensions74', ChoiceType::class, [
                'choices'     => $this->getExtensionChoices((new Php74AvailableExtensions())->getOptional()),
                'multiple'    => true,
                'label'       => 'Extensions (PHP 7.4)',
                'required'    => false,
                'constraints' => $phpOptionsConstraints,
            ])
            ->add('phpExtensions80', ChoiceType::class, [
                'choices'     => $this->getExtensionChoices((new Php80AvailableExtensions())->getOptional()),
                'multiple'    => true,
                'label'       => 'Extensions (PHP 8.0)',
                'required'    => false,
                'constraints' => $phpOptionsConstraints,
            ])
            ->add('phpExtensions81', ChoiceType::class, [
                'choices'     => $this->getExtensionChoices((new Php81AvailableExtensions())->getOptional()),
                'multiple'    => true,
                'label'       => 'Extensions (PHP 8.1)',
                'required'    => false,
                'constraints' => $phpOptionsConstraints,
            ]);
    }

    /**
     * Returns all available extensions as an array we can feed to ChoiceType.
     *
     * @param PhpExtension[] $rawChoices
     *
     * @return array<string, string>
     */
    private function getExtensionChoices(array $rawChoices): array
    {
        $choices = [];
        foreach ($rawChoices as $extension) {
            $choices[$extension->getName()] = $extension->getName();
        }

        return $choices;
    }

    /**
     * Gets ChoiceType choices for available PHP versions.
     *
     * @return array<string, string>
     */
    private function getVersionChoices(): array
    {
        $versions = [];
        foreach (Php::getSupportedVersions() as $version) {
            $versions[$version] = $version;
        }

        return $versions;
    }
}

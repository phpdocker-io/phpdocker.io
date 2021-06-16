<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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

use App\Entity\Generator\PhpOptions;
use PHPDocker\PhpExtension\Php72AvailableExtensions;
use PHPDocker\PhpExtension\Php73AvailableExtensions;
use PHPDocker\PhpExtension\Php74AvailableExtensions;
use PHPDocker\PhpExtension\Php80AvailableExtensions;
use PHPDocker\PhpExtension\PhpExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

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
        $builder
            ->add('hasGit', CheckboxType::class, [
                'label'    => 'Add git (eg for composer)',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => $this->getVersionChoices(),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'PHP Version',
            ])
            ->add('phpExtensions72', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php72AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.2.x)',
                'required' => false,
            ])
            ->add('phpExtensions73', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php73AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.3.x)',
                'required' => false,
            ])
            ->add('phpExtensions74', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php74AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.4.x)',
                'required' => false,
            ])
            ->add('phpExtensions80', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php80AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 8.0.x)',
                'required' => false,
            ]);
    }

    /**
     * Returns all available extensions as an array we can feed to ChoiceType.
     */
    private function getExtensionChoices($rawChoices): array
    {
        $choices = [];
        foreach ($rawChoices as $extension) {
            /** @var PhpExtension $extension */
            $choices[$extension->getName()] = $extension->getName();
        }

        return $choices;
    }

    /**
     * Gets ChoiceType choices for available PHP versions.
     */
    private function getVersionChoices(): array
    {
        $versions = [];
        foreach (PhpOptions::getSupportedVersions() as $version) {
            $versions[$version] = $version;
        }

        return $versions;
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     */
    protected function getDataClass(): string
    {
        return PhpOptions::class;
    }
}

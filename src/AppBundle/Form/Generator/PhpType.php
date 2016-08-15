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

namespace AppBundle\Form\Generator;

use AppBundle\Entity\Generator\PhpOptions;
use PHPDocker\PhpExtension\Php56AvailableExtensions;
use PHPDocker\PhpExtension\Php70AvailableExtensions;
use PHPDocker\PhpExtension\Php71AvailableExtensions;
use PHPDocker\PhpExtension\PhpExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for PHP options.
 *
 * @package AppBundle\Form\Generator
 * @author  Luis A. Pabon Flores
 */
class PhpType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('version', ChoiceType::class, [
                'choices'  => $this->getVersionChoices(),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'PHP Version'
            ])
            ->add('phpExtensions56', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php56AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 5.6.x)',
                'required' => false,
            ])
            ->add('phpExtensions70', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php70AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.0.x)',
                'required' => false,
            ])
            ->add('phpExtensions71', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php71AvailableExtensions::create()->getOptional()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.1.x)',
                'required' => false,
            ]);
    }

    /**
     * Returns all available extensions as an array we can feed to ChoiceType.
     *
     * @return array
     */
    private function getExtensionChoices($rawChoices)
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
     *
     * @return array
     */
    private function getVersionChoices()
    {
        $versions = [];
        foreach (PhpOptions::getSupportedVersions() as $version) {
            $versions[$version] = $version;
        }

        return $versions;
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return PhpOptions::class;
    }
}

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

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Base form for MySQL-like options.
 */
abstract class AbstractMySQLType extends AbstractGeneratorType
{
    /**
     * Return the name of the field for 'hasWhatever'.
     */
    abstract protected function getHasOptionFieldName(): string;

    /**
     * Return the label of the field 'hasWhatever'.
     */
    abstract protected function getHasOptionLabel(): string;

    /**
     * Return the list of available versions for the version selector field.
     */
    abstract protected function getVersionChoices(): array;

    /**
     * Return the method name (bool) on the entity to work out whether option is enabled.
     */
    abstract protected function getHasOptionFunctionName(): string;

    /**
     * Return the name of the validation group for this form type.
     */
    abstract protected function getValidationGroup(): string;

    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add($this->getHasOptionFieldName(), CheckboxType::class, [
                'label'    => $this->getHasOptionLabel(),
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => $this->getVersionChoices(),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Version',
            ])
            ->add('rootPassword', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Password for root user'],
            ])
            ->add('databaseName', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database name'],
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database username'],
            ])
            ->add('password', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database password'],
            ]);
    }

    protected function getValidationGroups(): callable
    {
        return function (FormInterface $form) {
            $data   = $form->getData();
            $groups = ['Default'];

            $hasOption = $this->getHasOptionFunctionName();
            if ($data->{$hasOption}() === true) {
                $groups[] = $this->getValidationGroup();
            }

            return $groups;
        };
    }
}

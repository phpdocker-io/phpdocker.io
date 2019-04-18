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

namespace App\Generator\Form;

use App\Generator\Entity\PostgresOptions;
use PHPDocker\Project\ServiceOptions\Postgres;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Form for Postgres options.
 *
 * @package App\Form\Generator
 * @author  Luis A. Pabon Flores
 */
class PostgresType extends AbstractGeneratorType
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
            ->add('hasPostgres', CheckboxType::class, [
                'label'    => 'Enable Postgres',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => array_flip(Postgres::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Version',
            ])
            ->add('rootUser', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Root username'],
            ])
            ->add('rootPassword', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Password for root user'],
            ])
            ->add('databaseName', TextType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Your app\'s database name'],
            ]);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass(): string
    {
        return PostgresOptions::class;
    }

    /**
     * @return callable
     */
    protected function getValidationGroups(): callable
    {
        return function (FormInterface $form) {
            /** @var \App\Generator\Entity\PostgresOptions $data */
            $data   = $form->getData();
            $groups = ['Default'];

            if ($data->hasPostgres() === true) {
                $groups[] = 'postgresOptions';
            }

            return $groups;
        };
    }
}

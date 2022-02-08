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

use App\PHPDocker\Project\ServiceOptions\Postgres;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Form for Postgres options.
 */
class PostgresType extends AbstractGeneratorType
{
    private const VALIDATION_GROUP = 'postgresOptions';

    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultConstraints = [
            new NotBlank(groups: [self::VALIDATION_GROUP]),
            new Length(min: 2, max: 128),
        ];

        $builder
            ->add('hasPostgres', CheckboxType::class, [
                'label'    => 'Enable Postgres',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'     => array_flip(Postgres::getChoices()),
                'expanded'    => false,
                'multiple'    => false,
                'label'       => 'Version',
                'constraints' => $defaultConstraints,
            ])
            ->add('rootUser', TextType::class, [
                'label'       => false,
                'attr'        => ['placeholder' => 'Root username'],
                'constraints' => $defaultConstraints,
            ])
            ->add('rootPassword', TextType::class, [
                'label'       => false,
                'attr'        => ['placeholder' => 'Password for root user'],
                'constraints' => $defaultConstraints,
            ])
            ->add('databaseName', TextType::class, [
                'label'       => false,
                'attr'        => ['placeholder' => 'Your app\'s database name'],
                'constraints' => $defaultConstraints,
            ]);
    }

    protected function getValidationGroups(): callable
    {
        return static function (FormInterface $form) {
            /** @var array<mixed> $data */
            $data   = $form->getData();
            $groups = ['Default'];

            if ($data['hasPostgres'] === true) {
                $groups[] = self::VALIDATION_GROUP;
            }

            return $groups;
        };
    }
}

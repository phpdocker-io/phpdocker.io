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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Project forms.
 */
class ProjectType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('basePort', IntegerType::class, [
                'label'       => 'Base port',
                'attr'        => ['placeholder' => 'For nginx, Mailhog control panel...'],
                'data'        => random_int(min: 2, max: 65) * 1000,
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Type(type: 'integer'),
                    new Range(min: 1025, max: 65535),
                ],
            ])
            ->add('hasMemcached', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Memcached',
            ])
            ->add('hasRedis', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Redis',
            ])
            ->add('hasMailhog', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Mailhog',
            ])
            ->add('hasClickhouse', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Clickhouse',
            ])
            ->add('phpOptions', PhpType::class, [
                'label'       => 'PHP Options',
                'constraints' => new Valid(),
            ])
            ->add('mysqlOptions', MySQLType::class, [
                'label'       => 'MySQL',
                'constraints' => new Valid(),
            ])
            ->add('mariadbOptions', MariaDBType::class, [
                'label'       => 'MariaDB',
                'constraints' => new Valid(),
            ])
            ->add('postgresOptions', PostgresType::class, [
                'label'       => 'Postgres',
                'constraints' => new Valid(),
            ])
            ->add('elasticsearchOptions', ElasticsearchType::class, [
                'label'       => 'Elasticsearch',
                'constraints' => new Valid(),
            ])
            ->add('workingDirOptions', WorkingDirType::class, [
                'label'       => 'Working Dir options',
                'constraints' => new Valid(),
            ]);
    }
}

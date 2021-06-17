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

use App\Entity\Generator\ElasticsearchOptions;
use App\PHPDocker\Project\ServiceOptions\Elasticsearch;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class ElasticsearchType
 */
class ElasticsearchType extends AbstractGeneratorType
{
    /**
     * Builds the form definition.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hasElasticsearch', CheckboxType::class, [
                'label'    => 'Enable Elasticsearch',
                'required' => false,
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => array_flip(Elasticsearch::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Version',
            ]);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     */
    protected function getDataClass(): string
    {
        return ElasticsearchOptions::class;
    }

    protected function getValidationGroups(): callable
    {
        return static function (FormInterface $form) {
            /** @var ElasticsearchOptions $data */
            $data   = $form->getData();
            $groups = ['Default'];

            if ($data->hasElasticsearch() === true) {
                $groups[] = 'elasticsearchOptions';
            }

            return $groups;
        };
    }
}

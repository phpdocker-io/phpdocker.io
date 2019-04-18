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

use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base class for forms.
 *
 * @package App\Form\Generator
 * @author  Luis A. Pabon Flores
 */
abstract class AbstractGeneratorType extends \Symfony\Component\Form\AbstractType
{
    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    abstract protected function getDataClass(): string;

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => $this->getDataClass(),
            'validation_groups' => $this->getValidationGroups(),
        ]);
    }

    /**
     * Override to set any additional validation groups.
     *
     * @return callable
     */
    protected function getValidationGroups(): callable
    {
        return function (FormInterface $form) {
            return ['Default'];
        };
    }
}

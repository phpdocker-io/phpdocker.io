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

namespace AppBundle\Form;

use AppBundle\Entity\ContactRequest;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Contact request form
 *
 * @package AppBundle\Form
 * @author  Luis A. Pabon Flores
 */
class ContactRequestType extends AbstractGeneratorType
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
            ->add('senderEmail', EmailType::class, [
                'label'    => false,
                'attr'     => ['placeholder' => 'Your email - optional, only if you\'d like a reply'],
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'label'    => false,
                'attr'     => ['placeholder' => 'Feedback, recommendations, feature requests...'],
                'required' => true,
            ]);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return ContactRequest::class;
    }
}

<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Base class for forms.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
abstract class AbstractType extends \Symfony\Component\Form\AbstractType
{
    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    abstract protected function getDataClass();

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => $this->getDataClass(),
            'validation_groups' => $this->getValidationGroups()
        ]);
    }

    /**
     * Override to set any additional validation groups.
     *
     * @return callable
     */
    protected function getValidationGroups() : callable
    {
        return function (FormInterface $form) {
            return ['Default'];
        };
    }
}

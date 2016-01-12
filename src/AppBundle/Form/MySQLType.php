<?php
namespace AppBundle\Form;

use AppBundle\Entity\MySQLOptions;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for MySQL options.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class MySQLType extends AbstractType
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
            ->add('rootPassword', TextType::class)
            ->add('databaseName', TextType::class)
            ->add('username', TextType::class)
            ->add('password', TextType::class);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return MySQLOptions::class;
    }
}

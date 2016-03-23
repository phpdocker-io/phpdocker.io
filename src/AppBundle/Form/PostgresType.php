<?php
namespace AppBundle\Form;

use AppBundle\Entity\PostgresOptions;
use AuronConsultingOSS\Docker\Project\ServiceOptions\Postgres;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Form for Postgres options.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
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
                'required' => false
            ])
            ->add('version', ChoiceType::class, [
                'choices'  => array_flip(Postgres::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Postgres version'
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
    protected function getDataClass()
    {
        return PostgresOptions::class;
    }

    /**
     * @return callable
     */
    protected function getValidationGroups() : callable
    {
        return function (FormInterface $form) {
            /** @var PostgresOptions $data */
            $data   = $form->getData();
            $groups = ['Default'];

            if ($data->hasPostgres() === true) {
                $groups[] = 'postgresOptions';
            }

            return $groups;
        };
    }
}

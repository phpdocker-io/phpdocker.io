<?php
namespace AppBundle\Form;

use AuronConsultingOSS\Docker\Project\ServiceOptions\Application;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for application options.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ApplicationType extends AbstractGeneratorType
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
            ->add('applicationType', ChoiceType::class, [
                'choices'  => array_flip(Application::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Application type'
            ])
            ->add('uploadSize', IntegerType::class, [
                'label'    => 'Max upload size (MB)',
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
        return Application::class;
    }
}

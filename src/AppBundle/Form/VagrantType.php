<?php
namespace AppBundle\Form;

use AuronConsultingOSS\Docker\Project\ServiceOptions\Vagrant;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vagrant options form.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class VagrantType extends AbstractGeneratorType
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
            ->add('shareType', ChoiceType::class, [
                'choices'  => array_flip(Vagrant::getChoices()),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'Shared folders filesystem'
            ])
            ->add('memory', IntegerType::class, [
                'label'    => 'RAM available',
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
        return Vagrant::class;
    }
}

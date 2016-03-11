<?php
namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Project forms.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ProjectType extends AbstractGeneratorType
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
            ->add('name', TextType::class, [
                'label' => 'Project name',
                'attr'  => ['placeholder' => 'Used on host, container, vm and folder names']
            ])
            ->add('basePort', IntegerType::class, [
                'label' => 'Base port',
                'attr'  => ['placeholder' => 'For nginx, Mailhog control panel...']
            ])
            ->add('hasMemcached', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Memcached'
            ])
            ->add('hasRedis', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Redis'
            ])
            ->add('hasMailhog', CheckboxType::class, [
                'required' => false,
                'label'    => 'Enable Mailhog'
            ])
            ->add('phpOptions', PhpType::class, ['label' => 'PHP Options'])
            ->add('mysqlOptions', MySQLType::class, ['label' => 'MySQL']);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return Project::class;
    }
}

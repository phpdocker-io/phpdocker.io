<?php
namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Project forms.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ProjectType extends AbstractType
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
            ->add('name', TextType::class)
            ->add('basePort', NumberType::class)
            ->add('hasMemcached', CheckboxType::class, ['required' => false])
            ->add('hasRedis', CheckboxType::class, ['required' => false])
            ->add('hasMailcatcher', CheckboxType::class, ['required' => false])
            ->add('mysqlOptions', MySQLType::class)
            ->add('phpOptions', PhpType::class)
        ;
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

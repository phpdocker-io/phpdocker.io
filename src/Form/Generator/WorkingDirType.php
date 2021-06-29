<?php
declare(strict_types=1);


namespace App\Form\Generator;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class WorkingDirType extends AbstractGeneratorType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localWorkingDir', TextType::class, [
                'label'       => 'Local working dir',
                'data'        => '.',
            ])
            ->add('dockerWorkingDir', TextType::class, [
                'label'       => 'Docker volume working dir',
                'data'        => '/application',
            ]);
    }

}
<?php
declare(strict_types=1);

namespace App\Form\Generator;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class WorkingDirType extends AbstractGeneratorType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('localWorkingDir', TextType::class, [
                'label' => 'App source code relative folder',
                'data'  => '.',
            ])
            ->add('dockerWorkingDir', TextType::class, [
                'label' => 'Containers workdir',
                'data'  => '/application',
            ]);
    }

}

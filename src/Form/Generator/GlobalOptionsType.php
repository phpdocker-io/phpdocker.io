<?php
declare(strict_types=1);

namespace App\Form\Generator;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

final class GlobalOptionsType extends AbstractGeneratorType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('basePort', IntegerType::class, [
                'label'       => 'Base port',
                'attr'        => ['placeholder' => 'For nginx, Mailhog control panel...'],
                'data'        => random_int(min: 2, max: 65) * 1000,
                'constraints' => [
                    new NotBlank(),
                    new Type(type: 'integer'),
                    new Range(min: 1025, max: 65535),
                ],
            ])
            ->add('appPath', TextType::class, [
                'label' => 'Your source code\'s path',
                'data'  => '.',
            ])
            ->add('dockerWorkingDir', TextType::class, [
                'label' => 'Containers workdir',
                'data'  => '/application',
            ]);
    }

}

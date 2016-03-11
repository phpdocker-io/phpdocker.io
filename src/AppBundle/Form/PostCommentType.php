<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form for post comments.-
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class PostCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('posterName', TextType::class, [
                'attr'     => ['placeholder' => 'Your name'],
                'required' => true,
            ])
            ->add('senderEmail', UrlType::class, [
                'attr'     => ['placeholder' => 'Your site\'s URL, if any'],
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'attr'     => ['placeholder' => 'Your comments'],
                'required' => true,
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PostComment'
        ));
    }
}

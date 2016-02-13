<?php
namespace AppBundle\Form;

use AppBundle\Entity\ContactRequest;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ContactRequest form
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ContactRequestType extends AbstractType
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
            ->add('senderName', TextType::class, [
                'label'    => 'Your name',
                'required' => true,
            ])
            ->add('senderEmail', EmailType::class, [
                'label'    => 'Your email',
                'attr'     => ['placeholder' => 'Optional, only if you\'d like a reply'],
                'required' => false,
            ])
            ->add('message', TextType::class, [
                'label'    => 'Your message',
                'attr'     => ['placeholder' => 'Feedback, recommendations, feature requests...'],
                'required' => false,
            ]);
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return ContactRequest::class;
    }
}

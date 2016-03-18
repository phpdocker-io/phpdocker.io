<?php
namespace AppBundle\Form;

use AppBundle\Entity\ContactRequest;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Contact request form
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ContactRequestType extends AbstractGeneratorType
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
            ->add('senderEmail', EmailType::class, [
                'label'    => false,
                'attr'     => ['placeholder' => 'Your email - optional, only if you\'d like a reply'],
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'label'    => false,
                'attr'     => ['placeholder' => 'Feedback, recommendations, feature requests...'],
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
        return ContactRequest::class;
    }
}

<?php
namespace AppBundle\Form;

use AppBundle\Entity\PhpOptions;
use AuronConsultingOSS\Docker\PhpExtension\Php56AvailableExtensions;
use AuronConsultingOSS\Docker\PhpExtension\Php70AvailableExtensions;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for PHP options.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class PhpType extends AbstractGeneratorType
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
            ->add('isSymfonyApp', CheckboxType::class, ['required' => false, 'label' => 'Is yours a Symfony app? Check this to configure nginx accordingly'])
            ->add('version', ChoiceType::class, [
                'choices'  => $this->getVersionChoices(),
                'expanded' => false,
                'multiple' => false,
                'label'    => 'PHP Version'
            ])
            ->add('phpExtensions56', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php56AvailableExtensions::create()->getOptionalPhpExtensions()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 5.6.x)',
                'required' => false,
            ])
            ->add('phpExtensions70', ChoiceType::class, [
                'choices'  => $this->getExtensionChoices(Php70AvailableExtensions::create()->getOptionalPhpExtensions()),
                'multiple' => true,
                'label'    => 'Extensions (PHP 7.0.x)',
                'required' => false,
            ]);
    }

    /**
     * Returns all available extensions as an array we can feed to ChoiceType.
     *
     * @return array
     */
    private function getExtensionChoices($rawChoices)
    {
        $choices = [];
        foreach ($rawChoices as $extension) {
            /** @var PhpExtension $extension */
            $choices[$extension->getName()] = $extension->getName();
        }

        return $choices;
    }

    /**
     * Gets ChoiceType choices for available PHP versions.
     *
     * @return array
     */
    private function getVersionChoices()
    {
        $versions = [];
        foreach (PhpOptions::getSupportedVersions() as $version) {
            $versions[$version] = $version;
        }

        arsort($versions);

        return $versions;
    }

    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return PhpOptions::class;
    }
}

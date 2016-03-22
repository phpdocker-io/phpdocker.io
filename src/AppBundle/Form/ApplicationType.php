<?php
namespace AppBundle\Form;

use AuronConsultingOSS\Docker\Project\ServiceOptions\Application;

/**
 * Form for application options.
 *
 * @package   AppBundle\Form
 * @copyright Auron Consulting Ltd
 */
class ApplicationType extends AbstractGeneratorType
{
    /**
     * This should return a string with the FQDN of the entity class associated to this form.
     *
     * @return string
     */
    protected function getDataClass()
    {
        return Application::class;
    }
}

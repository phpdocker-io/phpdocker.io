<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Options for Mailhog container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Mailhog extends Base
{
    /**
     * Returns the default hostname on each particular service.
     *
     * @return string
     */
    public function getHostnameSuffix() : string
    {
        return 'mailhog';
    }
}

<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for Mailhog container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class MailhogOptions extends AbstractServiceOptions
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

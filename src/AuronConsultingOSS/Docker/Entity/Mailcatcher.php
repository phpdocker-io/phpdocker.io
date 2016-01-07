<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for Mailcatcher container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Mailcatcher extends AbstractServiceOptions
{
    const DEFAULT_WEB_INTERFACE_PORT = 1080;

    /**
     * Returns the default hostname on each particular service.
     *
     * @return string
     */
    public function getDefaultHostname() : string
    {
        return 'mailcatcher';
    }
}

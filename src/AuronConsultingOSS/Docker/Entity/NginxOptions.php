<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for nginx container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class NginxOptions extends AbstractServiceOptions
{
    public function __construct()
    {
        $this->setEnabled(true);
    }

    /**
     * @inheritdoc
     */
    public function getHostnameSuffix() : string
    {
        return 'webserver';
    }
}

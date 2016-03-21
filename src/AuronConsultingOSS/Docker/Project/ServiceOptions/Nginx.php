<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Options for nginx container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Nginx extends Base
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

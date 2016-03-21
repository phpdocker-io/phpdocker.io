<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Options for redis container
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Redis extends Base
{
    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    public function getHostnameSuffix() : string
    {
        return 'redis';
    }
}

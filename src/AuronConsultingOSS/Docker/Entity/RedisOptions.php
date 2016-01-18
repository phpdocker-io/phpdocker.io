<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for redis container
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class RedisOptions extends AbstractServiceOptions
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

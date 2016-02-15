<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for Memcached container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class MemcachedOptions extends AbstractServiceOptions
{
    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    public function getHostnameSuffix() : string
    {
        return 'memcached';
    }
}

<?php
namespace AuronConsultingOSS\Docker\Interfaces;

/**
 * Used on objects which need to provide with a default hostname.
 *
 * @package AuronConsultingOSS\Docker\Interfaces
 */
interface HostnameSuffixInterface
{
    /**
     * Should return the
     *
     * @return string
     */
    public function getDefaultHostname() : string;
}

<?php
namespace PHPDocker\Interfaces;

/**
 * @package AuronConsultingOSS\Docker\Interfaces
 */
interface HostnameSuffixInterface
{
    /**
     * Should return the
     *
     * @return string
     */
    public function getHostnameSuffix() : string;
}

<?php
namespace AuronConsultingOSS\Docker\Entity;
use AuronConsultingOSS\Docker\Interfaces\HostnameSuffixInterface;

/**
 * Base class for service options.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
abstract class AbstractServiceOptions implements HostnameSuffixInterface
{
    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    abstract public function getHostnameSuffix() : string;
}

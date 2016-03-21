<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

use AuronConsultingOSS\Docker\Interfaces\HostnameSuffixInterface;

/**
 * Base class for service options.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
abstract class Base implements HostnameSuffixInterface
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    abstract public function getHostnameSuffix() : string;

    /**
     * @return boolean
     */
    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return Base
     */
    public function setEnabled(bool $enabled) : self
    {
        $this->enabled = $enabled;

        return $this;
    }
}

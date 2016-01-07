<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Base class for service options.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
abstract class AbstractServiceOptions
{
    /**
     * @var string
     */
    protected $hostname;

    /**
     * Returns the default hostname on each particular service.
     *
     * @return string
     */
    abstract public function getDefaultHostname() : string;

    /**
     * @return string
     */
    public function getHostname() : string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     *
     * @return self
     */
    public function setHostname($hostname) : AbstractServiceOptions
    {
        $this->hostname = $hostname;

        return $this;
    }
}

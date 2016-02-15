<?php
namespace AuronConsultingOSS\Docker\PhpExtension;

/**
 * Describes a PHP extension
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class PhpExtension
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $packages = [];

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PhpExtension
     */
    public function setName(string $name) : PhpExtension
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getPackages() : array
    {
        return $this->packages;
    }

    /**
     * @param string $package
     *
     * @return PhpExtension
     */
    public function addPackage(string $package) : PhpExtension
    {
        $this->packages[] = $package;

        return $this;
    }
}

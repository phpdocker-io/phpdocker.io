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
    protected $dependencies = [];

    /**
     * @var \stdClass
     */
    protected $customDist;

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
    public function getDependencies() : array
    {
        return $this->dependencies;
    }

    /**
     * @param string $dependency
     *
     * @return PhpExtension
     */
    public function addDepencency(string $dependency) : PhpExtension
    {
        $this->dependencies[] = $dependency;

        return $this;
    }

    /**
     * @return \stdClass|null
     */
    public function getCustomDist()
    {
        return $this->customDist;
    }

    /**
     * @param string $tarballUrl
     * @param string $uncompressedFolder
     *
     * @return PhpExtension
     */
    public function setCustomDist(string $tarballUrl, string $uncompressedFolder) : PhpExtension
    {
        $this->customDist                     = new \stdClass();
        $this->customDist->tarballUrl         = $tarballUrl;
        $this->customDist->uncompressedFolder = $uncompressedFolder;

        return $this;
    }
}

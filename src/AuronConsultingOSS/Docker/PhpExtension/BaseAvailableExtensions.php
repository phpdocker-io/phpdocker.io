<?php
namespace AuronConsultingOSS\Docker\PhpExtension;

/**
 * List of available php extensions and their dependencies.
 *
 * @package   AuronConsultingOSS\Docker\Resources
 * @copyright Auron Consulting Ltd
 */
abstract class BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    abstract protected function getMandatoryExtensionsMap() : array;

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    abstract protected function getOptionalExtensionsMap() : array;

    /**
     * Spawns a new instance to this class.
     *
     * @return self
     */
    public static function create() : self
    {
        static $instance;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Returns true if extension exists and is available.
     *
     * @param string $name
     *
     * @return bool
     */
    public function isAvailable(string $name) : bool
    {
        return array_key_exists($name, $this->getAllExtensions());
    }

    /**
     * Returns all available extensions, mandatory or not.
     *
     * @return array
     */
    public function getAllExtensions() : array
    {
        static $allExtensions;

        if ($allExtensions === null) {
            $allExtensions = array_merge($this->getMandatoryExtensionsMap(), $this->getOptionalExtensionsMap());
        }

        return $allExtensions;
    }

    /**
     * Returns a PhpExtension given its name.
     *
     * @param string $name
     *
     * @return PhpExtension
     * @throws Exception\NotFoundException
     */
    public function getPhpExtension(string $name) : PhpExtension
    {
        if (self::isAvailable($name) === false) {
            throw new Exception\NotFoundException(sprintf('PHP extension %s is not available to install', $name));
        }

        $raw = $this->getAllExtensions()[$name];

        $extension = new PhpExtension();
        $extension->setName($name);

        foreach ($raw['packages'] ?? [] as $package) {
            $extension->addPackage($package);
        }

        return $extension;
    }

    /**
     * Returns all mandatory php extensions as an array of PhpExtension.
     *
     * @return array
     * @throws Exception\NotFoundException
     */
    public function getMandatoryPhpExtensions() : array
    {
        $extensions = [];
        foreach ($this->getMandatoryExtensionsMap() as $name => $value) {
            $extensions[] = $this->getPhpExtension($name);
        }

        return $extensions;
    }
}

<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

use AuronConsultingOSS\Docker\PhpExtension\AvailableExtensionsFactory;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;

/**
 * Options for PHP container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Php extends Base
{
    /**
     * PHP 7.0.x
     */
    const PHP_VERSION_70 = '7.0.x';

    /**
     * PHP 5.6.x
     */
    const PHP_VERSION_56 = '5.6.x';

    /**
     * Supported PHP versions
     */
    const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_56,
        self::PHP_VERSION_70,
    ];

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var string
     */
    protected $version;

    public function __construct()
    {
        $this->setEnabled(true);
    }

    /**
     * @inheritdoc
     */
    public function getHostnameSuffix() : string
    {
        return 'php-fpm';
    }

    /**
     * @return array
     */
    public function getExtensions() : array
    {
        return $this->extensions;
    }

    /**
     * Adds an extension given the name only.
     *
     * @param string $extensionName
     *
     * @return Php
     */
    public function addExtensionByName(string $extensionName) : self
    {
        static $extensionInstance;

        if ($extensionInstance === null) {
            $extensionInstance = AvailableExtensionsFactory::create($this->getVersion());
        }

        $this->addExtension($extensionInstance->getPhpExtension($extensionName));

        return $this;
    }

    /**
     * @param PhpExtension $extension
     *
     * @return Php
     */
    public function addExtension(PhpExtension $extension) : self
    {
        $this->extensions[] = $extension;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return Php
     */
    public function setVersion(string $version) : self
    {
        if (in_array($version, self::SUPPORTED_VERSIONS, true) === false) {
            throw new \InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $version));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * Returns an array of supported PHP versions.
     *
     * @return array
     */
    public static function getSupportedVersions() : array
    {
        return self::SUPPORTED_VERSIONS;
    }
}

<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

use AuronConsultingOSS\Docker\PhpExtension\AvailableExtensions;
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
     * @var array
     */
    protected $extensions = [];

    /**
     * @var bool
     */
    protected $isSymfonyApp = false;

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
        $this->addExtension(AvailableExtensions::getPhpExtension($extensionName));

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
     * @return boolean
     */
    public function isSymfonyApp() : bool
    {
        return $this->isSymfonyApp;
    }

    /**
     * @param boolean $isSymfonyApp
     *
     * @return Php
     */
    public function setIsSymfonyApp(bool $isSymfonyApp) : self
    {
        $this->isSymfonyApp = $isSymfonyApp;

        return $this;
    }
}

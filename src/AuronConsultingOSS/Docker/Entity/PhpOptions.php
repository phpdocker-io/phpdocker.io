<?php
namespace AuronConsultingOSS\Docker\Entity;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;

/**
 * Options for PHP container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class PhpOptions extends AbstractServiceOptions
{
    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var bool
     */
    protected $isSymfonyApp = false;

    /**
     * @inheritdoc
     */
    public function getDefaultHostname() : string
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
     * @param PhpExtension $extension
     *
     * @return PhpOptions
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
     * @return PhpOptions
     */
    public function setIsSymfonyApp(bool $isSymfonyApp) : self
    {
        $this->isSymfonyApp = $isSymfonyApp;

        return $this;
    }
}

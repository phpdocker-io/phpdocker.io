<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity and validation.
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class PhpOptions extends \AuronConsultingOSS\Docker\Project\ServiceOptions\Php
{
    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions56 = [];

    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions70 = [];

    /**
     * @var bool
     */
    protected $isSymfonyApp = false;

    /**
     * @param array $phpExtensions
     *
     * @return PhpOptions
     */
    public function setPhpExtensions($phpExtensions) : self
    {
        $this->phpExtensions = $phpExtensions;

        foreach ($phpExtensions as $phpExtension) {
            $this->addExtensionByName($phpExtension);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions()
    {
        return $this->phpExtensions;
    }

    /**
     * @return array
     */
    public function getPhpExtensions70()
    {
        return $this->phpExtensions70;
    }

    /**
     * @param array $phpExtensions70
     */
    public function setPhpExtensions70(array $phpExtensions70 = [])
    {
        $this->phpExtensions70 = $phpExtensions70;
    }

    /**
     * @return array
     */
    public function getPhpExtensions56()
    {
        return $this->phpExtensions56;
    }

    /**
     * @param array $phpExtensions56
     *
     * @return PhpOptions
     */
    public function setPhpExtensions56(array $phpExtensions56 = [])
    {
        $this->phpExtensions56 = $phpExtensions56;

        return $this;
    }
}

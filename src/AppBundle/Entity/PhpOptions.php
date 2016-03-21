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
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions = [];

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
}

<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity and validation.
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class PhpOptions extends \AuronConsultingOSS\Docker\Entity\PhpOptions
{
    /**
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank,

     * })
     */
    protected $extensions = [];

    /**
     * @var bool
     */
    protected $isSymfonyApp = false;

    /**
     * @param array $extensions
     *
     * @return PhpOptions
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }
}

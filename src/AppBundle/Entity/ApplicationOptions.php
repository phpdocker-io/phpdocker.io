<?php
namespace AppBundle\Entity;

use AppBundle\Assert as CustomAssert;
use AuronConsultingOSS\Docker\Project\ServiceOptions\Application;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Validation for Application options
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class ApplicationOptions extends Application
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @CustomAssert\ApplicationType()
     */
    protected $applicationType;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @Assert\Range(min="2", max="2147483647")
     */
    protected $uploadSize;
}

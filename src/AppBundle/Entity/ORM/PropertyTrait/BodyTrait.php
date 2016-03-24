<?php
namespace AppBundle\Entity\ORM\PropertyTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Body ORM entity trait.
 *
 * @package   AppBundle\Entity\ORM\Traits
 * @copyright Auron Consulting Ltd
 */
trait BodyTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     */
    private $body;

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return self
     */
    public function setBody(string $body) : self
    {
        $this->body = $body;

        return $this;
    }
}

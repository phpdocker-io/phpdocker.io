<?php
namespace AppBundle\Entity\ORM\PropertyTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Is active ORM entity trait.
 *
 * @package   AppBundle\Entity\ORM\Traits
 * @copyright Auron Consulting Ltd
 */
trait ActiveTrait
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $active = true;

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     *
     * @return self
     */
    public function setActive(bool $active) : self
    {
        $this->active = $active;

        return $this;
    }
}

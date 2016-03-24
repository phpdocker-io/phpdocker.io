<?php
namespace AppBundle\Entity\ORM\PropertyTrait;

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
    private $active = false;

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

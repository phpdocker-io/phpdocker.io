<?php
namespace AppBundle\Entity\ORM\PropertyTrait;

/**
 * Primary key ORM entity trait
 *
 * @package   AppBundle\Entity\ORM\Traits
 * @copyright Auron Consulting Ltd
 */
trait PrimaryKeyTrait
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id) : self
    {
        $this->id = $id;

        return $this;
    }
}

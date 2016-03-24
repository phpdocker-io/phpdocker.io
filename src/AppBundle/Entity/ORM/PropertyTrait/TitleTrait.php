<?php
namespace AppBundle\Entity\ORM\PropertyTrait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Title ORM entity trait.
 *
 * @package   AppBundle\Entity\ORM\Traits
 * @copyright Auron Consulting Ltd
 */
trait TitleTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1, max = 255)
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }
}

<?php
namespace AppBundle\Entity\ORM;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Categories
 *
 * @ORM\Entity()
 *
 * @package   AppBundle\Entity\ORM
 * @copyright Auron Consulting Ltd
 */
class Category
{
    /**
     * Bring in primary key
     */
    use PropertyTrait\PrimaryKeyTrait;

    /**
     * Bring in title property
     */
    use PropertyTrait\TitleTrait;

    /**
     * Bring in timestamps and their doctrine behaviors
     */
    use PropertyTrait\TimestampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}

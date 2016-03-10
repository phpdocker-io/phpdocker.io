<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes a news post.
 *
 * @ORM\Entity()
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class Post
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
     * Bring in body property
     */
    use PropertyTrait\BodyTrait;

    /**
     * Bring in active property
     */
    use PropertyTrait\ActiveTrait;

    /**
     * Bring in timestamps and their doctrine behaviors
     */
    use PropertyTrait\TimestampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\Slug(fields={"createdAt", "title"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="PostComment", mappedBy="post", cascade={"all"})
     */
    private $postComments;

    /**
     * Initialise post collection
     */
    public function __construct()
    {
        $this->postComments = new ArrayCollection();
    }

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
     * @return self
     */
    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param PostComment $postComment
     *
     * @return self
     */
    public function addPostComment(PostComment $postComment) : self
    {
        $this->postComments[] = $postComment;
        $postComment->setPost($this);

        return $this;
    }

    /**
     * @param PostComment $postComment
     *
     * @return self
     */
    public function removePostComment(PostComment $postComment) : self
    {
        $this->postComments->removeElement($postComment);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPostComments() : Collection
    {
        return $this->postComments;
    }

    /**
     * Returns a count of all post comments associated to this post
     *
     * @return int
     */
    public function getCountPostComments() : int
    {
        return $this->postComments->count();
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return sprintf('%s (%s)', $this->getTitle(), $this->getCreatedAt());
    }
}

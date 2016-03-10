<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @ORM\OneToMany(targetEntity="Post", mappedBy="post", cascade={"all"})
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
     * @param PostComment $postComment
     *
     * @return self
     */
    public function addPostComment(PostComment $postComment) : self
    {
        $this->postComments[] = $postComment;
        $postComment->setPortfolioItem($this);

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
     * @return string
     */
    public function __toString() : string
    {
        return sprintf('%s (%s)', $this->getTitle(), $this->getCreatedAt());
    }
}

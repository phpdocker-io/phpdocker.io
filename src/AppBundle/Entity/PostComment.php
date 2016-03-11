<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes a post comment
 *
 * @ORM\Entity()
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class PostComment
{
    /**
     * Bring in primary key
     */
    use PropertyTrait\PrimaryKeyTrait;

    /**
     * Bring in body property
     */
    use PropertyTrait\BodyTrait;

    /**
     * Bring in timestamps and their doctrine behaviors
     */
    use PropertyTrait\TimestampableTrait;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $posterName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $posterUrl;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="postComments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    private $post;

    /**
     * @return string
     */
    public function getPosterName()
    {
        return $this->posterName;
    }

    /**
     * @param string $posterName
     *
     * @return self
     */
    public function setPosterName(string $posterName = null) : self
    {
        $this->posterName = $posterName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosterUrl()
    {
        return $this->posterUrl;
    }

    /**
     * @param string $posterUrl
     *
     * @return self
     */
    public function setPosterUrl(string $posterUrl = null) : self
    {
        $this->posterUrl = $posterUrl;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost() : Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return self
     */
    public function setPost(Post $post) : self
    {
        $this->post = $post;

        return $this;
    }
}

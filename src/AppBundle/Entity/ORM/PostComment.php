<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace AppBundle\Entity\ORM;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes a post comment
 *
 * @ORM\Entity()
 *
 * @package AppBundle\Entity\ORM
 * @author  Luis A. Pabon Flores
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
    public function getPosterName(): string
    {
        return $this->posterName;
    }

    /**
     * @param string $posterName
     *
     * @return self
     */
    public function setPosterName(string $posterName = null): self
    {
        $this->posterName = $posterName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosterUrl(): ?string
    {
        return $this->posterUrl;
    }

    /**
     * @param string $posterUrl
     *
     * @return self
     */
    public function setPosterUrl(string $posterUrl = null): self
    {
        $this->posterUrl = $posterUrl;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return self
     */
    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}

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

namespace App\ORM;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes a news post.
 *
 * @ORM\Entity()
 * @ApiResource()
 *
 * @package App\ORM
 * @author  Luis A. Pabon Flores
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
     * @ORM\Column(type="text", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     */
    private $bodyIntro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true)
     */
    private $slug;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Post
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyIntro(): ?string
    {
        return $this->bodyIntro;
    }

    /**
     * @param string $bodyIntro
     *
     * @return Post
     */
    public function setBodyIntro(string $bodyIntro): self
    {
        $this->bodyIntro = $bodyIntro;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->getTitle(), $this->getCreatedAt());
    }
}

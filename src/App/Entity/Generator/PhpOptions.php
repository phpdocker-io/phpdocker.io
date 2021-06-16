<?php
/**
 * Copyright 2016 Luis Alberto Pabón Flores
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

namespace App\Entity\Generator;

use PHPDocker\Project\ServiceOptions\Php as BasePhpOptions;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity and validation.
 */
class PhpOptions extends BasePhpOptions
{
    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions72 = [];

    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions73 = [];

    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions74 = [];

    /**
     * This does not exist on parent project. Needs to be redirected to $phpExtensions
     * based on version.
     *
     * @var array
     *
     * @Assert\All({
     *     @Assert\NotBlank
     * })
     */
    protected $phpExtensions80 = [];

    /**
     * @return array
     */
    public function getPhpExtensions72(): array
    {
        return $this->phpExtensions72;
    }

    /**
     * @param array $phpExtensions72
     *
     * @return self
     */
    public function setPhpExtensions72(array $phpExtensions72 = []): self
    {
        $this->phpExtensions72 = $phpExtensions72;

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions73(): array
    {
        return $this->phpExtensions73;
    }

    /**
     * @param array $phpExtensions73
     *
     * @return self
     */
    public function setPhpExtensions73(array $phpExtensions73 = []): self
    {
        $this->phpExtensions73 = $phpExtensions73;

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions74(): array
    {
        return $this->phpExtensions74;
    }

    /**
     * @param array $phpExtensions74
     *
     * @return self
     */
    public function setPhpExtensions74(array $phpExtensions74 = []): self
    {
        $this->phpExtensions74 = $phpExtensions74;

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions80(): array
    {
        return $this->phpExtensions80;
    }

    /**
     * @param array $phpExtensions80
     *
     * @return self
     */
    public function setPhpExtensions80(array $phpExtensions80): self
    {
        $this->phpExtensions80 = $phpExtensions80;

        return $this;
    }
}

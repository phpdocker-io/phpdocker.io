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

namespace App\Entity\Generator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity and validation.
 *
 * @package App\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class PhpOptions extends \PHPDocker\Project\ServiceOptions\Php
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
    protected $phpExtensions56 = [];

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
    protected $phpExtensions70 = [];

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
    protected $phpExtensions71 = [];

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
     * @return array
     */
    public function getPhpExtensions70(): array
    {
        return $this->phpExtensions70;
    }

    /**
     * @param array $phpExtensions70
     *
     * @return self
     */
    public function setPhpExtensions70(array $phpExtensions70 = []): self
    {
        $this->phpExtensions70 = $phpExtensions70;

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions71(): array
    {
        return $this->phpExtensions71;
    }

    /**
     * @param array $phpExtensions71
     *
     * @return self
     */
    public function setPhpExtensions71(array $phpExtensions71 = []): self
    {
        $this->phpExtensions71 = $phpExtensions71;

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions56(): array
    {
        return $this->phpExtensions56;
    }

    /**
     * @param array $phpExtensions56
     *
     * @return self
     */
    public function setPhpExtensions56(array $phpExtensions56 = []): self
    {
        $this->phpExtensions56 = $phpExtensions56;

        return $this;
    }

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
}

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

namespace PHPDocker\Project\ServiceOptions;

use PHPDocker\Interfaces\ContainerNameSuffixInterface;

/**
 * Base class for service options.
 *
 * @package PHPDocker\Entity
 * @author  Luis A. Pabon Flores
 */
abstract class Base implements ContainerNameSuffixInterface
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    abstract public function getContainerNameSuffix(): string;

    /**
     * @return boolean
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return Base
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}

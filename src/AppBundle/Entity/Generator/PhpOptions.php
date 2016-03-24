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

namespace AppBundle\Entity\Generator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity and validation.
 *
 * @package AppBundle\Entity\ORM
 * @author  Luis A. Pabon Flores
 */
class PhpOptions extends \AuronConsultingOSS\Docker\Project\ServiceOptions\Php
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
     * @param array $phpExtensions
     *
     * @return PhpOptions
     */
    public function setPhpExtensions($phpExtensions) : self
    {
        $this->phpExtensions = $phpExtensions;

        foreach ($phpExtensions as $phpExtension) {
            $this->addExtensionByName($phpExtension);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPhpExtensions70()
    {
        return $this->phpExtensions70;
    }

    /**
     * @param array $phpExtensions70
     */
    public function setPhpExtensions70(array $phpExtensions70 = [])
    {
        $this->phpExtensions70 = $phpExtensions70;
    }

    /**
     * @return array
     */
    public function getPhpExtensions56()
    {
        return $this->phpExtensions56;
    }

    /**
     * @param array $phpExtensions56
     *
     * @return PhpOptions
     */
    public function setPhpExtensions56(array $phpExtensions56 = [])
    {
        $this->phpExtensions56 = $phpExtensions56;

        return $this;
    }
}

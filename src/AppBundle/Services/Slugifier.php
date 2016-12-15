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

namespace AppBundle\Services;

use Cocur\Slugify\Slugify;
use PHPDocker\Interfaces\SlugifierInterface;

/**
 * String slugifier.
 *
 * @package AppBundle\Services
 * @author  Luis A. Pabon Flores
 */
class Slugifier implements SlugifierInterface
{
    /**
     * @var Slugify
     */
    protected $slugifier;

    /**
     * Ensure we receive the slugifier.
     *
     * @param Slugify $slugifier
     */
    public function __construct(Slugify $slugifier)
    {
        $this->slugifier = $slugifier;
    }

    /**
     * Takes a string and returns a slugified version of it.
     *
     * @param string $string
     *
     * @return string
     */
    public function slugify(string $string): string
    {
        return $this->slugifier->slugify($string);
    }
}

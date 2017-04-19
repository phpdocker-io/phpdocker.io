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

namespace PHPDocker\PhpExtension;

/**
 * Factory to specific PHP extensions list based on php version.
 *
 * @package PHPDocker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class AvailableExtensionsFactory
{
    /**
     * PHP 7.0.x
     */
    const PHP_VERSION_70 = '7.0.x';

    /**
     * PHP 7.0.x
     */
    const PHP_VERSION_71 = '7.1.x';

    /**
     * PHP 5.6.x
     */
    const PHP_VERSION_56 = '5.6.x';

    /**
     * Supported PHP versions
     */
    const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_56 => Php56AvailableExtensions::class,
        self::PHP_VERSION_70 => Php70AvailableExtensions::class,
        self::PHP_VERSION_71 => Php71AvailableExtensions::class,
    ];

    /**
     * Returns an instance to the appropriate class for extensions for a given php version.
     *
     * @param string $phpVersion
     *
     * @return mixed
     */
    public static function create(string $phpVersion)
    {
        if (array_key_exists($phpVersion, self::SUPPORTED_VERSIONS) === false) {
            throw new \InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $phpVersion));
        }

        $className = self::SUPPORTED_VERSIONS[$phpVersion];

        return $className::create();
    }
}

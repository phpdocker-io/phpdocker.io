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
 */
class AvailableExtensionsFactory
{
    private const PHP_VERSION_72 = '7.2.x';
    private const PHP_VERSION_73 = '7.3.x';
    private const PHP_VERSION_74 = '7.4.x';
    private const PHP_VERSION_80 = '8.0.x';

    /**
     * Supported PHP versions
     */
    private const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_72 => Php72AvailableExtensions::class,
        self::PHP_VERSION_73 => Php73AvailableExtensions::class,
        self::PHP_VERSION_74 => Php74AvailableExtensions::class,
        self::PHP_VERSION_80 => Php80AvailableExtensions::class,
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

<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
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
 *
 */

namespace App\PHPDocker\PhpExtension;

use InvalidArgumentException;

/**
 * Factory to specific PHP extensions list based on php version.
 */
class AvailableExtensionsFactory
{
    private const PHP_VERSION_74 = '7.4';
    private const PHP_VERSION_80 = '8.0';
    private const PHP_VERSION_81 = '8.1';

    /**
     * Supported PHP versions
     */
    private const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_74 => Php74AvailableExtensions::class,
        self::PHP_VERSION_80 => Php80AvailableExtensions::class,
        self::PHP_VERSION_81 => Php81AvailableExtensions::class,
    ];

    /**
     * Returns an instance to the appropriate class for extensions for a given php version.
     */
    public static function create(string $phpVersion): BaseAvailableExtensions
    {
        if (array_key_exists($phpVersion, self::SUPPORTED_VERSIONS) === false) {
            throw new InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $phpVersion));
        }

        $className = self::SUPPORTED_VERSIONS[$phpVersion];

        return new $className;
    }
}

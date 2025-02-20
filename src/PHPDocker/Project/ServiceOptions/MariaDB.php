<?php
declare(strict_types=1);
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

namespace App\PHPDocker\Project\ServiceOptions;

/**
 * Options for MariaDB container.
 */
class MariaDB extends AbstractMySQL
{
    /**
     * Available versions
     */
    private const string VERSION_104 = '10.4';
    private const string VERSION_105 = '10.5';
    private const string VERSION_106 = '10.6';
    private const string VERSION_107 = '10.7';
    private const string VERSION_108 = '10.8';
    private const string VERSION_109 = '10.9';
    private const string VERSION_1010 = '10.10';
    private const string VERSION_1011 = '10.11';
    private const string VERSION_110  = '11.0';

    private const array ALLOWED_VERSIONS = [
        self::VERSION_110 => '11.0.x',
        self::VERSION_1011 => '10.11.x',
        self::VERSION_1010 => '10.10.x',
        self::VERSION_109  => '10.9.x',
        self::VERSION_108  => '10.8.x',
        self::VERSION_107  => '10.7.x',
        self::VERSION_106  => '10.6.x',
        self::VERSION_105  => '10.5.x',
        self::VERSION_104  => '10.4.x',
    ];

    /**
     * Set default version.
     */
    public function __construct()
    {
        $this->version = self::VERSION_110;
    }

    protected function getExternalPortOffset(): ?int
    {
        return 3;
    }

    /**
     * @inheritdoc
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_VERSIONS;
    }
}

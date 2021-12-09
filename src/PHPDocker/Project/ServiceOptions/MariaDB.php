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
    private const VERSION_55  = '5.5';
    private const VERSION_100 = '10.0';
    private const VERSION_101 = '10.1';
    private const VERSION_102 = '10.2';
    private const VERSION_103 = '10.3';
    private const VERSION_104 = '10.4';
    private const VERSION_105 = '10.5';
    private const VERSION_106 = '10.6';

    private const ALLOWED_VERSIONS = [
        self::VERSION_106 => '10.6.x',
        self::VERSION_105 => '10.5.x',
        self::VERSION_104 => '10.4.x',
        self::VERSION_103 => '10.3.x',
        self::VERSION_102 => '10.2.x',
        self::VERSION_101 => '10.1.x',
        self::VERSION_100 => '10.0.x',
        self::VERSION_55  => '5.5.x',
    ];

    /**
     * Set default version.
     */
    public function __construct()
    {
        $this->version = self::VERSION_106;
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

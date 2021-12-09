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
 * Options for MySQL container.
 */
class MySQL extends AbstractMySQL
{
    /**
     * Available versions
     */
    private const VERSION_55 = '5.5';
    private const VERSION_56 = '5.6';
    private const VERSION_57 = '5.7';
    private const VERSION_80 = '8.0';

    private const ALLOWED_VERSIONS = [
        self::VERSION_80 => '8.0',
        self::VERSION_57 => '5.7.x',
        self::VERSION_56 => '5.6.x',
        self::VERSION_55 => '5.5.x',
    ];

    public function __construct()
    {
        $this->version = self::VERSION_80;
    }

    protected function getExternalPortOffset(): ?int
    {
        return 2;
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

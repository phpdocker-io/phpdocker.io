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
final class MySQL extends AbstractMySQL
{
    private const string VERSION_80 = '8.0';

    public function __construct(
        string $version = self::VERSION_80,
        ?string $rootPassword = null,
        ?string $databaseName = null,
        ?string $username = null,
        ?string $password = null,
        bool $enabled = false,
    ) {
        parent::__construct(
            version: $version,
            rootPassword: $rootPassword,
            databaseName: $databaseName,
            username: $username,
            password: $password,
            enabled: $enabled,
        );
    }

    protected function getExternalPortOffset(): int
    {
        return 2;
    }

    /**
     * @inheritdoc
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        return self::choices();
    }

    /**
     * @return array<string, string>
     */
    private static function choices(): array
    {
        return MySQLVersion::choices();
    }
}

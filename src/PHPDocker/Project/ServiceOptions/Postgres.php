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

namespace App\PHPDocker\Project\ServiceOptions;

/**
 * Postgres configuration
 */
final class Postgres extends Base
{
    private const string VERSION_15 = '15';

    private readonly string $version;
    private readonly string $rootUser;
    private readonly string $rootPassword;
    private readonly string $databaseName;

    public function __construct(
        string $version = self::VERSION_15,
        string $rootUser = '',
        string $rootPassword = '',
        string $databaseName = '',
        bool $enabled = false,
    ) {
        parent::__construct($enabled);

        $this->version       = self::fromString($version)->value;
        $this->rootUser      = $rootUser;
        $this->rootPassword  = $rootPassword;
        $this->databaseName  = $databaseName;
    }

    protected function getExternalPortOffset(): int
    {
        return 4;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getRootUser(): string
    {
        return $this->rootUser;
    }

    public function getRootPassword(): string
    {
        return $this->rootPassword;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    /**
     * @return array<int|string, string>
     */
    public static function getChoices(): array
    {
        return self::choices();
    }

    /**
     * @return array<int|string, string>
     */
    private static function choices(): array
    {
        return PostgresVersion::choices();
    }

    private static function fromString(string $version): PostgresVersion
    {
        return PostgresVersion::fromString($version);
    }
}

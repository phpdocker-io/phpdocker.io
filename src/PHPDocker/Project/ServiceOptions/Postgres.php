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

use InvalidArgumentException;

/**
 * Postgres configuration
 */
class Postgres extends Base
{
    /**
     * Available versions
     */
    private const string VERSION_15 = '15';
    private const string VERSION_14 = '14';
    private const string VERSION_13 = '13';
    private const string VERSION_12 = '12';
    private const string VERSION_11 = '11';
    private const string VERSION_10 = '10';
    private const string VERSION_96 = '9.6';

    private const ALLOWED_VERSIONS = [
        self::VERSION_15 => '15.x',
        self::VERSION_14 => '14.x',
        self::VERSION_13 => '13.x',
        self::VERSION_12 => '12.x',
        self::VERSION_11 => '11.x',
        self::VERSION_10 => '10.x',
        self::VERSION_96 => '9.6.x',
    ];

    private string $version = self::VERSION_15;
    private string $rootUser;
    private string $rootPassword;
    private string $databaseName;

    protected function getExternalPortOffset(): ?int
    {
        return 4;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        if (array_key_exists($version, self::ALLOWED_VERSIONS) === false) {
            throw new InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version = $version;

        return $this;
    }

    public function getRootUser(): string
    {
        return $this->rootUser;
    }

    public function setRootUser(string $rootUser): self
    {
        $this->rootUser = $rootUser;

        return $this;
    }

    public function getRootPassword(): string
    {
        return $this->rootPassword;
    }

    public function setRootPassword(string $rootPassword): self
    {
        $this->rootPassword = $rootPassword;

        return $this;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function setDatabaseName(string $databaseName): self
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_VERSIONS;
    }
}

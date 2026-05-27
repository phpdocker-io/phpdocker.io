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
final class Postgres extends Base
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

    private const array ALLOWED_VERSIONS = [
        self::VERSION_15 => '15.x',
        self::VERSION_14 => '14.x',
        self::VERSION_13 => '13.x',
        self::VERSION_12 => '12.x',
        self::VERSION_11 => '11.x',
        self::VERSION_10 => '10.x',
        self::VERSION_96 => '9.6.x',
    ];

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

        if (array_key_exists($version, self::ALLOWED_VERSIONS) === false) {
            throw new InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version       = $version;
        $this->rootUser      = $rootUser;
        $this->rootPassword  = $rootPassword;
        $this->databaseName  = $databaseName;
    }

    protected function getExternalPortOffset(): ?int
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
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        // @phpstan-ignore return.type (numeric string keys become int at runtime)
        return self::ALLOWED_VERSIONS;
    }
}

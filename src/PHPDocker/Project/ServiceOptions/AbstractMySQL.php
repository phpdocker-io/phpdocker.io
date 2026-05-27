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
 * Options for MySQL-like containers.
 */
abstract class AbstractMySQL extends Base
{
    private readonly string $version;
    private readonly ?string $rootPassword;
    private readonly ?string $databaseName;
    private readonly ?string $username;
    private readonly ?string $password;

    /**
     * Return an array of available versions, like so:
     * [
     *    'version' => 'version_name',
     *    ...
     * ]
     *
     * @return array<string, string>
     */
    abstract public static function getChoices(): array;

    public function __construct(
        string $version,
        ?string $rootPassword = null,
        ?string $databaseName = null,
        ?string $username = null,
        ?string $password = null,
        bool $enabled = false,
    ) {
        parent::__construct($enabled);

        if (array_key_exists($version, static::getChoices()) === false) {
            throw new InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version       = $version;
        $this->rootPassword   = $rootPassword;
        $this->databaseName   = $databaseName;
        $this->username       = $username;
        $this->password       = $password;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getRootPassword(): ?string
    {
        return $this->rootPassword;
    }

    public function getDatabaseName(): ?string
    {
        return $this->databaseName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}

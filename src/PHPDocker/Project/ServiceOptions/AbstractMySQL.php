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
    protected string  $version;
    protected ?string $rootPassword;
    protected ?string $databaseName;
    protected ?string $username;
    protected ?string $password;

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

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        if (array_key_exists($version, static::getChoices()) === false) {
            throw new InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version = $version;

        return $this;
    }

    public function getRootPassword(): ?string
    {
        return $this->rootPassword;
    }

    public function setRootPassword(string $rootPassword = null): self
    {
        $this->rootPassword = $rootPassword;

        return $this;
    }

    public function getDatabaseName(): ?string
    {
        return $this->databaseName;
    }

    public function setDatabaseName(string $databaseName = null): self
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username = null): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password = null): self
    {
        $this->password = $password;

        return $this;
    }
}

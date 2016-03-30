<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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

namespace PHPDocker\Project\ServiceOptions;

/**
 * Postgres configuration
 *
 * @package AuronConsultingOSS\Docker\Project\ServiceOptions
 * @author  Luis A. Pabon Flores
 */
class Postgres extends Base
{
    /**
     * Available versions
     */
    const VERSION_95 = '9.5';
    const VERSION_94 = '9.4';

    const ALLOWED_VERSIONS = [
        self::VERSION_95 => '9.5.x',
        self::VERSION_94 => '9.4.x',
    ];

    /**
     * @var string
     */
    protected $version = self::VERSION_95;

    /**
     * @var string
     */
    protected $rootUser;

    /**
     * @var string
     */
    protected $rootPassword;

    /**
     * @var string
     */
    protected $databaseName;

    /**
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return Postgres
     */
    public function setVersion(string $version) : self
    {
        if (array_key_exists($version, self::ALLOWED_VERSIONS) === false) {
            throw new \InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootUser()
    {
        return $this->rootUser;
    }

    /**
     * @param string $rootUser
     *
     * @return Postgres
     */
    public function setRootUser(string $rootUser) : self
    {
        $this->rootUser = $rootUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootPassword()
    {
        return $this->rootPassword;
    }

    /**
     * @param string $rootPassword
     *
     * @return Postgres
     */
    public function setRootPassword(string $rootPassword) : self
    {
        $this->rootPassword = $rootPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @param string $databaseName
     *
     * @return Postgres
     */
    public function setDatabaseName(string $databaseName) : self
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * Returns all supported Postgres versions with their descriptions.
     *
     * @return array
     */
    public static function getChoices() : array
    {
        return self::ALLOWED_VERSIONS;
    }

    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    public function getHostnameSuffix() : string
    {
        return 'postgres';
    }
}

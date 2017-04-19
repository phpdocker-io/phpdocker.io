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
 * Options for Elasticsearch container.
 *
 * @package PHPDocker\Entity
 * @author  Luis A. Pabon Flores
 */
class Elasticsearch extends Base
{
    /**
     * Available versions
     */
    const VERSION_17 = '1.7';
    const VERSION_20 = '2.0';
    const VERSION_21 = '2.1';
    const VERSION_22 = '2.2';
    const VERSION_23 = '2.3';
    const VERSION_24 = '2.4';
    const VERSION_50 = '5.0';
    const VERSION_51 = '5.1';
    const VERSION_52 = '5.2';
    const VERSION_53 = '5.3';

    const ALLOWED_VERSIONS = [
        self::VERSION_53 => '5.3.x',
        self::VERSION_52 => '5.1.x',
        self::VERSION_51 => '5.1.x',
        self::VERSION_50 => '5.0.x',
        self::VERSION_24 => '2.4.x',
        self::VERSION_23 => '2.3.x',
        self::VERSION_22 => '2.2.x',
        self::VERSION_21 => '2.1.x',
        self::VERSION_20 => '2.0.x',
        self::VERSION_17 => '1.7.x',
    ];

    /**
     * @var string
     */
    protected $version = self::VERSION_23;

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return Elasticsearch
     */
    public function setVersion($version)
    {
        if (array_key_exists($version, self::ALLOWED_VERSIONS) === false) {
            throw new \InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * Returns all supported MySQL versions with their descriptions.
     *
     * @return array
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_VERSIONS;
    }

    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    public function getContainerNameSuffix(): string
    {
        return 'elasticsearch';
    }
}

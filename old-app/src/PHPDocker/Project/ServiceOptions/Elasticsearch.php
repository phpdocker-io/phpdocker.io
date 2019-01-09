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
 * @package PHPDocker\Project\ServiceOptions
 * @author  Luis A. Pabon Flores
 */
class Elasticsearch extends Base
{
    /**
     * Available versions
     */
    protected const VERSION_56 = '5.6';
    protected const VERSION_65 = '6.5.4';

    private const ALLOWED_VERSIONS = [
        self::VERSION_65 => '6.5.x',
        self::VERSION_56 => '5.6.x',
    ];

    /**
     * @var string
     */
    protected $version = self::VERSION_65;

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
}

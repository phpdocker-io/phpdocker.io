<?php
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

namespace PHPDocker\Project\ServiceOptions;

use InvalidArgumentException;

/**
 * Options for Elasticsearch container.
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

    protected $version = self::VERSION_65;

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

    /**
     * Returns all supported MySQL versions with their descriptions.
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_VERSIONS;
    }
}

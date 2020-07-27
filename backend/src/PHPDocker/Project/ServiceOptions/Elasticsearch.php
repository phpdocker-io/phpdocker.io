<?php
declare(strict_types=1);
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

use InvalidArgumentException;

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
    protected const VERSION_78 = '7.8.0';
    protected const VERSION_77 = '7.7.1';
    protected const VERSION_76 = '7.6.2';
    protected const VERSION_68 = '6.8.10';

    private const ALLOWED_VERSIONS = [
        self::VERSION_78 => '7.8.x',
        self::VERSION_77 => '7.7.x',
        self::VERSION_76 => '7.6.x',
        self::VERSION_68 => '6.8.x',
    ];

    /**
     * @var string
     */
    protected $version = self::VERSION_78;

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
            throw new InvalidArgumentException(sprintf('Version %s is not supported', $version ?? 'null'));
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

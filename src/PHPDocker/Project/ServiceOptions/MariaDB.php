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
 * Options for MariaDB container.
 *
 * @package PHPDocker\Project\ServiceOptions
 * @author  Luis A. Pabon Flores
 */
class MariaDB extends AbstractMySQL
{
    /**
     * Available versions
     */
    protected const VERSION_55  = '5.5';
    protected const VERSION_100 = '10.0';
    protected const VERSION_101 = '10.1';

    protected const ALLOWED_VERSIONS = [
        self::VERSION_101 => '10.1.x',
        self::VERSION_100 => '10.0.x',
        self::VERSION_55  => '5.5.x',
    ];

    /**
     * Set default version.
     */
    public function __construct()
    {
        $this->version = self::VERSION_101;
    }

    /**
     * @inheritdoc
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_VERSIONS;
    }
}

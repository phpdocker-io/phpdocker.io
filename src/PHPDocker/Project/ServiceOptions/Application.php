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
 * Describes a few things about the user's project.
 *
 * @package PHPDocker\Project\ServiceOptions
 * @author  Luis A. Pabon Flores
 */
class Application
{
    /**
     * Supported application types
     */
    const APPLICATION_TYPE_SYMFONY = 'symfony';
    const APPLICATION_TYPE_PHALCON = 'phalcon';
    const APPLICATION_TYPE_GENERIC = 'generic';
    const APPLICATION_TYPE_SILEX   = 'silex';

    /**
     * Allowed application types with short description
     */
    const ALLOWED_APPLICATION_TYPES = [
        self::APPLICATION_TYPE_GENERIC => 'Generic: Zend, Laravel, Lumen...',
        self::APPLICATION_TYPE_SYMFONY => 'Symfony',
        self::APPLICATION_TYPE_PHALCON => 'Phalcon 3',
        self::APPLICATION_TYPE_SILEX   => 'Silex',
    ];

    /**
     * @var string
     */
    protected $applicationType = self::APPLICATION_TYPE_GENERIC;

    /**
     * @var int
     */
    protected $uploadSize = 100;

    /**
     * @return string
     */
    public function getApplicationType(): string
    {
        return $this->applicationType;
    }

    /**
     * @param string $applicationType
     *
     * @return Application
     */
    public function setApplicationType(string $applicationType): self
    {
        if (array_key_exists($applicationType, self::ALLOWED_APPLICATION_TYPES) === false) {
            throw new \InvalidArgumentException(sprintf('Application type %s not supported', $applicationType));
        }

        $this->applicationType = $applicationType;

        return $this;
    }

    /**
     * Returns all supported application types with their descriptions.
     *
     * @return array
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_APPLICATION_TYPES;
    }

    /**
     * @return int
     */
    public function getUploadSize(): int
    {
        return $this->uploadSize;
    }

    /**
     * @param int $uploadSize
     *
     * @return Application
     */
    public function setUploadSize(int $uploadSize): self
    {
        $this->uploadSize = $uploadSize;

        return $this;
    }
}

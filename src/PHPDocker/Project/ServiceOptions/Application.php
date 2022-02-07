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
 * Describes a few things about the user's project.
 */
class Application
{
    /**
     * Supported application types
     */
    private const APPLICATION_TYPE_SYMFONY = 'symfony';
    private const APPLICATION_TYPE_GENERIC = 'generic';

    /**
     * Allowed application types with short description
     */
    private const ALLOWED_APPLICATION_TYPES = [
        self::APPLICATION_TYPE_GENERIC => 'Generic: Symfony, Laravel, Slim...',
        self::APPLICATION_TYPE_SYMFONY => '[Legacy] Symfony 2/3',
    ];

    public function __construct(private string $applicationType)
    {
    }

    public function getApplicationType(): ?string
    {
        return $this->applicationType;
    }

    public function setApplicationType(string $applicationType): self
    {
        if (array_key_exists($applicationType, self::ALLOWED_APPLICATION_TYPES) === false) {
            throw new InvalidArgumentException(sprintf('Application type %s not supported', $applicationType));
        }

        $this->applicationType = $applicationType;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        return self::ALLOWED_APPLICATION_TYPES;
    }
}

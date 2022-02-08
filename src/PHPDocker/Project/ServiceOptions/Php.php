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

use App\PHPDocker\PhpExtension\AvailableExtensionsFactory;
use App\PHPDocker\PhpExtension\PhpExtension;
use InvalidArgumentException;

/**
 * Options for PHP container.
 */
class Php extends Base
{
    public const PHP_VERSION_74 = '7.4';
    public const PHP_VERSION_80 = '8.0';
    public const PHP_VERSION_81 = '8.1';

    private string $version;

    /** @var PhpExtension[] */
    private array $extensions = [];

    /**
     * Supported PHP versions
     */
    private const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_81,
        self::PHP_VERSION_80,
        self::PHP_VERSION_74,
    ];

    /**
     * @param string[] $extensions
     * @param string   $frontControllerPath Path to the app's front controller, relative to project root
     */
    public function __construct(
        string $version,
        array $extensions,
        private bool $hasGit,
        private string $frontControllerPath
    ) {
        $this->setEnabled(true);

        // Validate & set version
        if (in_array($version, self::SUPPORTED_VERSIONS, true) === false) {
            throw new InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $version));
        }

        $this->version = $version;

        // Parse extensions
        foreach ($extensions as $phpExtension) {
            $this->addExtensionByName($phpExtension);
        }
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function hasGit(): bool
    {
        return $this->hasGit;
    }

    /**
     * @return PhpExtension[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * Returns an array of supported PHP versions.
     *
     * @return string[]
     */
    public static function getSupportedVersions(): array
    {
        return self::SUPPORTED_VERSIONS;
    }

    /**
     * Adds an extension given the name only.
     */
    private function addExtensionByName(string $extensionName): void
    {
        static $extensionInstance;

        if ($extensionInstance === null) {
            $extensionInstance = AvailableExtensionsFactory::create($this->getVersion());
        }

        $this->extensions[] = $extensionInstance->getPhpExtension($extensionName);
    }

    public function getFrontControllerPath(): string
    {
        return $this->frontControllerPath;
    }
}

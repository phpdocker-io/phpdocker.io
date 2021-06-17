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
    public const PHP_VERSION_72 = '7.2.x';
    public const PHP_VERSION_73 = '7.3.x';
    public const PHP_VERSION_74 = '7.4.x';
    public const PHP_VERSION_80 = '8.0.x';

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var bool
     */
    protected $hasGit = false;

    /**
     * Supported PHP versions
     */
    public const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_80,
        self::PHP_VERSION_74,
        self::PHP_VERSION_73,
        self::PHP_VERSION_72,
    ];

    /**
     * @var string
     */
    protected $version;

    public function __construct()
    {
        $this->setEnabled(true);
    }

    public function getExtensions(): array
    {
        return $this->extensions;
    }

    public function setPhpExtensions(array $phpExtensions): self
    {
        foreach ($phpExtensions as $phpExtension) {
            $this->addExtensionByName($phpExtension);
        }

        return $this;
    }

    /**
     * Adds an extension given the name only.
     */
    public function addExtensionByName(string $extensionName): self
    {
        static $extensionInstance;

        if ($extensionInstance === null) {
            $extensionInstance = AvailableExtensionsFactory::create($this->getVersion());
        }

        $this->addExtension($extensionInstance->getPhpExtension($extensionName));

        return $this;
    }

    public function addExtension(PhpExtension $extension): self
    {
        $this->extensions[] = $extension;

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        if (in_array($version, self::SUPPORTED_VERSIONS, true) === false) {
            throw new InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $version));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * Returns an array of supported PHP versions.
     */
    public static function getSupportedVersions(): array
    {
        return self::SUPPORTED_VERSIONS;
    }

    public function hasGit(): bool
    {
        return $this->hasGit;
    }

    public function setHasGit(bool $hasGit): self
    {
        $this->hasGit = $hasGit;

        return $this;
    }
}

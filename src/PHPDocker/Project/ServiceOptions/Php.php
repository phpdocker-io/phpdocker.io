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

/**
 * Options for PHP container.
 */
final class Php extends Base
{
    private readonly string $version;

    /** @var PhpExtension[] */
    private readonly array $extensions;

    /**
     * @param string[] $extensions
     * @param string   $frontControllerPath Path to the app's front controller, relative to project root
     */
    public function __construct(
        string $version,
        array $extensions,
        private readonly bool $hasGit,
        private readonly string $frontControllerPath
    ) {
        parent::__construct(true);

        $this->version = self::fromString($version)->value;

        // Parse extensions
        $parsedExtensions = [];
        foreach ($extensions as $phpExtension) {
            $parsedExtensions[] = $this->addExtensionByName($phpExtension);
        }

        $this->extensions = $parsedExtensions;
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
        return self::values();
    }

    /**
     * Adds an extension given the name only.
     */
    private function addExtensionByName(string $extensionName): PhpExtension
    {
        return AvailableExtensionsFactory::create($this->getVersion())->getPhpExtension($extensionName);
    }

    public function getFrontControllerPath(): string
    {
        return $this->frontControllerPath;
    }

    private static function values(): array
    {
        return PhpVersion::values();
    }

    private static function fromString(string $version): PhpVersion
    {
        return PhpVersion::fromString($version);
    }
}

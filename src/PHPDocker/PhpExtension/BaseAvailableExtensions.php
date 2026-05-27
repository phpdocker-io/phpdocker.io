<?php
declare(strict_types=1);
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

namespace App\PHPDocker\PhpExtension;

/**
 * List of available php extensions and their dependencies.
 */
abstract class BaseAvailableExtensions
{
    /**
     * @var array<string, PhpExtension>
     */
    private array $allExtensions = [];

    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing a list of package names.
     *
     * @return array<string, string[]>
     */
    abstract protected function getMandatoryExtensionsMap(): array;

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing a list of package names.
     *
     * @return array<string, string[]>
     */
    abstract protected function getOptionalExtensionsMap(): array;

    /**
     * Returns true if extension exists and is available.
     */
    public function isAvailable(string $name): bool
    {
        return array_key_exists($name, $this->getAll());
    }

    /**
     * Returns all available extensions, mandatory or not.
     *
     * @return array<string, PhpExtension>
     */
    public function getAll(): array
    {
        if ($this->allExtensions === []) {
            $this->allExtensions = array_merge(
                $this->createExtensions($this->getMandatoryExtensionsMap()),
                $this->createExtensions($this->getOptionalExtensionsMap()),
            );
        }

        return $this->allExtensions;
    }

    /**
     * Returns a PhpExtension given its name.
     *
     * @throws Exception\NotFoundException
     */
    public function getPhpExtension(string $name): PhpExtension
    {
        if ($this->isAvailable($name) === false) {
            throw new Exception\NotFoundException(sprintf('PHP extension %s is not available to install', $name));
        }

        return $this->getAll()[$name];
    }

    /**
     * Returns all optional php extensions as an array of PhpExtension.
     *
     * @return PhpExtension[]
     * @throws Exception\NotFoundException
     */
    public function getOptional(): array
    {
        return array_values($this->createExtensions($this->getOptionalExtensionsMap()));
    }

    /**
     * @param array<string, string[]> $extensionMap
     *
     * @return array<string, PhpExtension>
     */
    private function createExtensions(array $extensionMap): array
    {
        $extensions = [];
        foreach ($extensionMap as $name => $packages) {
            $extensions[$name] = new PhpExtension($name, $packages);
        }

        return $extensions;
    }
}

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

namespace PHPDocker\PhpExtension;

/**
 * List of available php extensions and their dependencies.
 *
 * @package PHPDocker\Resources
 * @author  Luis A. Pabon Flores
 */
abstract class BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    abstract protected function getMandatoryExtensionsMap(): array;

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    abstract protected function getOptionalExtensionsMap(): array;

    /**
     * Spawns a new instance to this class.
     *
     * @return self
     */
    public static function create(): self
    {
        static $instance;

        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Returns true if extension exists and is available.
     *
     * @param string $name
     *
     * @return bool
     */
    public function isAvailable(string $name): bool
    {
        return array_key_exists($name, $this->getAll());
    }

    /**
     * Returns all available extensions, mandatory or not.
     *
     * @return array
     */
    public function getAll(): array
    {
        static $allExtensions;

        if ($allExtensions === null) {
            $allExtensions = array_merge($this->getMandatoryExtensionsMap(), $this->getOptionalExtensionsMap());
        }

        return $allExtensions;
    }

    /**
     * Returns a PhpExtension given its name.
     *
     * @param string $name
     *
     * @return PhpExtension
     * @throws Exception\NotFoundException
     */
    public function getPhpExtension(string $name): PhpExtension
    {
        if ($this->isAvailable($name) === false) {
            throw new Exception\NotFoundException(sprintf('PHP extension %s is not available to install', $name));
        }

        $raw = $this->getAll()[$name];

        $extension = new PhpExtension();
        $extension->setName($name);

        foreach ($raw['packages'] ?? [] as $package) {
            $extension->addPackage($package);
        }

        return $extension;
    }

    /**
     * Returns all mandatory php extensions as an array of PhpExtension.
     *
     * @return array
     * @throws Exception\NotFoundException
     */
    public function getMandatory(): array
    {
        $extensions = [];
        foreach ($this->getMandatoryExtensionsMap() as $name => $value) {
            $extensions[] = $this->getPhpExtension($name);
        }

        return $extensions;
    }

    /**
     * Returns all optional php extensions as an array of PhpExtension.
     *
     * @return array
     * @throws Exception\NotFoundException
     */
    public function getOptional(): array
    {
        $extensions = [];
        foreach ($this->getOptionalExtensionsMap() as $name => $value) {
            $extensions[] = $this->getPhpExtension($name);
        }

        return $extensions;
    }
}

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

namespace PHPDocker\PhpExtension;

/**
 * Describes a PHP extension
 */
class PhpExtension
{
    protected string $name;
    protected array  $packages = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PhpExtension
    {
        $this->name = $name;

        return $this;
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function addPackage(string $package): PhpExtension
    {
        $this->packages[] = $package;

        return $this;
    }
}

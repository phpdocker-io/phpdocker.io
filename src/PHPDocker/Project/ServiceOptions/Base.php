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

namespace App\PHPDocker\Project\ServiceOptions;

/**
 * Base class for service options.
 */
abstract class Base
{
    protected bool $enabled = false;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Return this service's external (meaning bound into the host from docker) port as a function of a given base
     * port plus our internal offset.
     */
    public function getExternalPort(int $basePort): ?int
    {
        $offset = $this->getExternalPortOffset();

        return $offset !== null ? ($basePort + $offset) : null;
    }

    /**
     * When calculating our external port, we add this offset to a given base port.
     *
     * Override downstream for services you want them to have an external port.
     */
    protected function getExternalPortOffset(): ?int
    {
        return null;
    }
}

<?php
declare(strict_types=1);
/**
 * Copyright 2019 Luis Alberto Pabón Flores
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

namespace App\Http;

/**
 * Describes a request error.
 *
 * @package App\Http
 */
class Error
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $property;

    public function __construct(string $code, string $description, string $property = '')
    {
        $this->code        = $code;
        $this->description = $description;
        $this->property    = $property;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    public function toArray(): array
    {
        return [
            'code'        => $this->code,
            'description' => $this->description,
            'property'    => $this->property,
        ];
    }
}

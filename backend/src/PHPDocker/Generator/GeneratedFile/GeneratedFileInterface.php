<?php
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

namespace PHPDocker\Generator\GeneratedFile;

/**
 * Describes a parsed, generated file by its filename and contents.
 *
 * @package PHPDocker\Interfaces
 */
interface GeneratedFileInterface
{
    /**
     * Must return the relative filename this file will be described by.
     *
     * Eg:
     *   - Folder\SomeFile
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Must return the file contents as a string.
     *
     * @return string
     */
    public function getContents(): string;
}

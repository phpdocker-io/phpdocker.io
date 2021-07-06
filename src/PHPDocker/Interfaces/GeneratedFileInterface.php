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

namespace App\PHPDocker\Interfaces;

/**
 * Generator files know how to render themselves. This interface defines how to get to the rendered contents as well
 * as the filename.
 *
 * How they perform the rendering is up to the file itself.
 */
interface GeneratedFileInterface
{
    /**
     * Returns a string rendered rendition of the file.
     * Eg:
     *   - Folder\SomeFile
     */
    public function getContents(): string;

    /**
     * Returns the filename of the current file.
     */
    public function getFilename(): string;
}

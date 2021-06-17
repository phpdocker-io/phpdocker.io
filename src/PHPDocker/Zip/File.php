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

namespace App\PHPDocker\Zip;

use App\PHPDocker\Interfaces\ArchiveInterface;

/**
 * Represents a zip file.
 */
class File implements ArchiveInterface
{
    protected string $filename;
    protected string $tmpFilename;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTmpFilename(): string
    {
        return $this->tmpFilename;
    }

    public function setTmpFilename(string $tmpFilename): self
    {
        $this->tmpFilename = $tmpFilename;

        return $this;
    }
}

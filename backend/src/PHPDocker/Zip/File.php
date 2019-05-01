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

namespace PHPDocker\Zip;

use function base64_encode;
use function file_get_contents;
use function unlink;

/**
 * Represents a zip file.
 *
 * @author  Luis A. Pabon Flores
 */
class File
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $tmpFilename;

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return File
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmpFilename(): string
    {
        return $this->tmpFilename;
    }

    /**
     * @param string $tmpFilename
     *
     * @return File
     */
    public function setTmpFilename(string $tmpFilename): self
    {
        $this->tmpFilename = $tmpFilename;

        return $this;
    }

    /**
     * Returns the file as a base64 encoded blob.
     *
     * @return string
     */
    public function getBase64EncodedPayload(): string
    {
        return base64_encode(file_get_contents($this->tmpFilename));
    }

    /**
     * Deletes the file from its temporary location.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return unlink($this->tmpFilename);
    }
}

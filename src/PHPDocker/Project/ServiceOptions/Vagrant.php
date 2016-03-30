<?php
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

namespace PHPDocker\Project\ServiceOptions;

/**
 * Vagrant options for the project.
 *
 * @package AuronConsultingOSS\Docker\Project\ServiceOptions
 * @author  Luis A. Pabon Flores
 */
class Vagrant
{
    /**
     * Supported shared folder types
     */
    const SHARE_TYPE_VBOXSF = 'vboxsf';
    const SHARE_TYPE_NFS    = 'nfs';
    const SHARE_TYPE_SMB    = 'smb';

    const ALLOWED_SHARE_TYPES = [
        self::SHARE_TYPE_NFS    => 'NFS (Linux, Mac)',
        self::SHARE_TYPE_VBOXSF => 'Virtualbox vboxsf (any)',
        self::SHARE_TYPE_SMB    => 'SMB (Windows, experimental)',
    ];

    /**
     * @var string
     */
    protected $shareType = self::SHARE_TYPE_NFS;

    /**
     * Memory allowed to VM in MB
     *
     * @var int
     */
    protected $memory = 1024;

    /**
     * @return string
     */
    public function getShareType() : string
    {
        return $this->shareType;
    }

    /**
     * @param string $shareType
     *
     * @return Vagrant
     */
    public function setShareType(string $shareType) : self
    {
        if (array_key_exists($shareType, self::ALLOWED_SHARE_TYPES) === false) {
            throw new \InvalidArgumentException(sprintf('Share type %s is unsupported', $shareType));
        }

        $this->shareType = $shareType;

        return $this;
    }

    /**
     * @return int
     */
    public function getMemory() : int
    {
        return $this->memory;
    }

    /**
     * @param int $memory
     *
     * @return Vagrant
     */
    public function setMemory(int $memory) : self
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Returns all supported shared folder types with their descriptions.
     *
     * @return array
     */
    public static function getChoices() : array
    {
        return self::ALLOWED_SHARE_TYPES;
    }
}

<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Vagrant options for the project.
 *
 * @package   AuronConsultingOSS\Docker\Project\ServiceOptions
 * @copyright Auron Consulting Ltd
 */
class Vagrant
{
    /**
     * Supported shared folder types
     */
    const SHARE_TYPE_VBOXSF = 'vboxsf';
    const SHARE_TYPE_NFS    = 'nfs';

    const ALLOWED_SHARE_TYPES = [
        self::SHARE_TYPE_NFS    => 'NFS',
        self::SHARE_TYPE_VBOXSF => 'Virtualbox vboxsf',
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

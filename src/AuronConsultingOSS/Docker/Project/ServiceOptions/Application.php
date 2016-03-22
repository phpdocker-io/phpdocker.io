<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Describes a few things about the user's project.
 *
 * @package   AuronConsultingOSS\Docker\Project\ServiceOptions
 * @copyright Auron Consulting Ltd
 */
class Application extends Base
{
    /**
     * Supported application types
     */
    const APPLICATION_TYPE_SYMFONY = 'symfony';
    const APPLICATION_TYPE_PHALCON = 'phalcon';
    const APPLICATION_TYPE_GENERIC = 'generic';

    /**
     * Allowed application types with short description
     */
    const ALLOWED_APPLICATION_TYPES = [
        self::APPLICATION_TYPE_GENERIC => 'Symfony 2/3',
        self::APPLICATION_TYPE_PHALCON => 'Phalcon 2',
        self::APPLICATION_TYPE_SYMFONY => 'Zend, Laravel...',
    ];

    /**
     * @var string
     */
    private $applicationType = self::APPLICATION_TYPE_GENERIC;

    /**
     * @var int
     */
    private $uploadSize = 100;

    /**
     * @return string
     */
    public function getApplicationType() : string
    {
        return $this->applicationType;
    }

    /**
     * @param string $applicationType
     *
     * @return Application
     */
    public function setApplicationType(string $applicationType) : self
    {
        if (array_key_exists($applicationType, self::ALLOWED_APPLICATION_TYPES) === false) {
            throw new \InvalidArgumentException(sprintf('Application type %s not supported', $applicationType));
        }

        $this->applicationType = $applicationType;

        return $this;
    }

    /**
     * Returns all supported application types with their descriptions.
     *
     * @return array
     */
    public function getChoices() : array
    {
        return self::ALLOWED_APPLICATION_TYPES;
    }

    /**
     * @return int
     */
    public function getUploadSize() : int
    {
        return $this->uploadSize;
    }

    /**
     * @param int $uploadSize
     *
     * @return Application
     */
    public function setUploadSize(int $uploadSize) : self
    {
        $this->uploadSize = $uploadSize;

        return $this;
    }

    /**
     * Return the suffix to be used on hostname construction.
     *
     * @return string
     */
    public function getHostnameSuffix() : string
    {
        return '';
    }
}

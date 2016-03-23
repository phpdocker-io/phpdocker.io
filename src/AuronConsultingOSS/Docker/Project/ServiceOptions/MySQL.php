<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Options for MySQL container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class MySQL extends Base
{
    /**
     * Available versions
     */
    const VERSION_55 = '5.5';
    const VERSION_56 = '5.6';
    const VERSION_57 = '5.7';

    const ALLOWED_VERSIONS = [
        self::VERSION_57 => '5.7.x',
        self::VERSION_56 => '5.6.x',
        self::VERSION_55 => '5.5.x',
    ];

    /**
     * @var string
     */
    protected $version = self::VERSION_57;

    /**
     * @var string
     */
    protected $rootPassword;

    /**
     * @var string
     */
    protected $databaseName;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return MySQL
     */
    public function setVersion(string $version) : self
    {
        if (array_key_exists($version, self::ALLOWED_VERSIONS) === false) {
            throw new \InvalidArgumentException(sprintf('Version %s is not supported', $version));
        }

        $this->version = $version;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getHostnameSuffix() : string
    {
        return 'mysql';
    }

    /**
     * @return string
     */
    public function getRootPassword()
    {
        return $this->rootPassword;
    }

    /**
     * @param string $rootPassword
     *
     * @return MySQL
     */
    public function setRootPassword(string $rootPassword = null) : MySQL
    {
        $this->rootPassword = $rootPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @param string $databaseName
     *
     * @return MySQL
     */
    public function setDatabaseName(string $databaseName = null) : MySQL
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return MySQL
     */
    public function setUsername(string $username = null) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return MySQL
     */
    public function setPassword(string $password = null) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns all supported MySQL versions with their descriptions.
     *
     * @return array
     */
    public static function getChoices() : array
    {
        return self::ALLOWED_VERSIONS;
    }
}

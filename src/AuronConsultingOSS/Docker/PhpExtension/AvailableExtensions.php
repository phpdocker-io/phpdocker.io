<?php
namespace AuronConsultingOSS\Docker\PhpExtension;

/**
 * List of available php extensions and their dependencies.
 *
 * @package   AuronConsultingOSS\Docker\Resources
 * @copyright Auron Consulting Ltd
 */
class AvailableExtensions
{
    /**
     * List of extensions always to install
     */
    const MANDATORY_EXTENSIONS_MAP = [
        'bz2'      => ['dependencies' => ['libbz2-dev']],
        'calendar' => [],
        'iconv'    => [],
        'intl'     => ['dependencies' => ['libicu-dev']],
        'mbstring' => [],
        'mcrypt'   => ['dependencies' => ['libmcrypt-dev']],
        'json'     => [],
        'posix'    => [],
    ];

    /**
     * List of allowed extensions
     */
    const OPTIONAL_EXTENSIONS_MAP = [
        # Extensions not included on dist
        'memcached' => [
            'dependencies' => ['libmemcached-dev'],
            'custom-dist'  => [
                'tarball'             => 'https://codeload.github.com/php-memcached-dev/php-memcached/tar.gz/php7',
                'uncompressed-folder' => 'php-memcached-php7'
            ]
        ],

        'redis'        => [
            'dependencies' => ['libmemcached-dev'],
            'custom-dist'  => [
                'tarball'             => 'https://codeload.github.com/phpredis/phpredis/tar.gz/php7',
                'uncompressed-folder' => 'phpredis-php7'
            ]
        ],

        # Disabled extensions - don't work for now
        # 'com_dotnet'   => [],
        #'imap'         => ['dependencies' => ['libc-client-dev libkrb5-dev']],
        # 'oci8'         => [],
        #'odbc'         => ['dependencies' => ['unixodbc-dev'],
        #'pdo_dblib'         => ['dependencies' => ['freetds-dev',  'libsybdb5', 'libdbd-freetds'],
        # 'pdo_oci'      => [],
        # 'pdo_odbc'     => [],
        # 'xml'          => [],
        # 'xmlreader'    => [],
        # 'xmlrpc'       => [],
        # 'xmlwriter'    => [],
        # 'ldap'         => ['dependencies' => ['libldap2-dev'], 'configure' => ['--with-libdir=lib/x86_64-linux-gnu/']],

        # The easy ones
        'bcmath'       => [],
        'ctype'        => [],
        'curl'         => ['dependencies' => ['libcurl4-openssl-dev']],
        'dba'          => [],
        'dom'          => ['dependencies' => ['libxml2-dev']],
        'enchant'      => ['dependencies' => ['libenchant-dev']],
        'exif'         => [],
        'fileinfo'     => [],
        'ftp'          => ['dependencies' => ['libssl-dev']],
        'gd'           => ['dependencies' => ['libjpeg-dev', 'libpng12-dev']],
        'gettext'      => [],
        'gmp'          => [],
        'interbase'    => ['dependencies' => ['firebird-dev']],
        'mysqli'       => ['dependencies' => ['libmysqlclient-dev']],
        'opcache'      => [],
        'pcntl'        => [],
        'pdo'          => [],
        'pdo_firebird' => ['dependencies' => ['firebird-dev']],
        'pdo_mysql'    => ['dependencies' => ['libmysqlclient-dev']],
        'pdo_pgsql'    => ['dependencies' => ['libpq-dev']],
        'pdo_sqlite'   => ['dependencies' => ['libsqlite3-dev']],
        'pgsql'        => ['dependencies' => ['libpq-dev']],
        'phar'         => [],
        'pspell'       => ['dependencies' => ['libpspell-dev']],
        'recode'       => ['dependencies' => ['librecode-dev']],
        'session'      => [],
        'shmop'        => [],
        'simplexml'    => [],
        'snmp'         => ['dependencies' => ['libsnmp-dev']],
        'soap'         => ['dependencies' => ['libxml2-dev']],
        'sockets'      => [],
        'sysvmsg'      => [],
        'sysvsem'      => [],
        'sysvshm'      => [],
        'tidy'         => ['dependencies' => ['libtidy-dev']],
        'tokenizer'    => [],
        'wddx'         => [],
        'xsl'          => ['dependencies' => ['libxslt1-dev']],
    ];

    /**
     * Returns true if extension exists and is available.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isAvailable(string $name) : bool
    {
        return array_key_exists($name, self::getAllExtensions());
    }

    /**
     * Returns all available extensions, mandatory or not.
     *
     * @return array
     */
    public static function getAllExtensions() : array
    {
        static $allExtensions;

        if ($allExtensions === null) {
            $allExtensions = array_merge(self::MANDATORY_EXTENSIONS_MAP, self::OPTIONAL_EXTENSIONS_MAP);
        }

        return $allExtensions;
    }

    /**
     * Returns a PhpExtension given its name.
     *
     * @param string $name
     *
     * @return PhpExtension
     * @throws NotFoundException
     */
    public static function getPhpExtension(string $name) : PhpExtension
    {
        if (self::isAvailable($name) === false) {
            throw new NotFoundException(sprintf('PHP extension %s is not available to install', $name));
        }

        $raw = self::getAllExtensions()[$name];

        $extension = new PhpExtension();
        $extension->setName($name);

        foreach ($raw['dependencies'] ?? [] as $dependency) {
            $extension->addDepencency($dependency);
        }

        $customDist = $raw['custom-dist'] ?? [];
        if (isset($customDist['tarball']) === true && isset($customDist['uncompressed-folder']) === true) {
            $extension->setCustomDist($customDist['tarball'], $customDist['uncompressed-folder']);
        }

        return $extension;
    }

    /**
     * Returns all mandatory php extensions as an array of PhpExtension.
     *
     * @return array
     * @throws NotFoundException
     */
    public static function getMandatoryPhpExtensions() : array
    {
        $extensions = [];
        foreach (self::MANDATORY_EXTENSIONS_MAP as $name => $value) {
            $extensions[] = self::getPhpExtension($name);
        }

        return $extensions;
    }
}

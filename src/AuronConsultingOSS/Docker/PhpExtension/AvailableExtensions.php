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
     * List of allowed extensions
     */
    const EXTENSIONS_MAP = [
        # Extensions not included on dist
        'memcached'    => [
            'dependencies' => [],
            'custom-dist'  => [
                'tarball'             => 'https://codeload.github.com/php-memcached-dev/php-memcached/tar.gz/php7',
                'uncompressed-folder' => 'php-memcached-php7'
            ]
        ],

        # Extensions that have dependencies
        'zip'          => ['dependencies' => ['zlib1g-dev']],
        'zlib'         => ['dependencies' => ['zlib1g-dev']],

        # The easy ones
        'bcmath'       => [],
        'bz2'          => [],
        'calendar'     => [],
        'com_dotnet'   => [],
        'ctype'        => [],
        'curl'         => [],
        'date'         => [],
        'dba'          => [],
        'dom'          => [],
        'enchant'      => [],
        'exif'         => [],
        'fileinfo'     => [],
        'filter'       => [],
        'ftp'          => [],
        'gd'           => [],
        'gettext'      => [],
        'gmp'          => [],
        'hash'         => [],
        'iconv'        => [],
        'imap'         => [],
        'interbase'    => [],
        'intl'         => [],
        'json'         => [],
        'ldap'         => [],
        'libxml'       => [],
        'mbstring'     => [],
        'mcrypt'       => [],
        'mysqli'       => [],
        'mysqlnd'      => [],
        'oci8'         => [],
        'odbc'         => [],
        'opcache'      => [],
        'openssl'      => [],
        'pcntl'        => [],
        'pcre'         => [],
        'pdo'          => [],
        'pdo_dblib'    => [],
        'pdo_firebird' => [],
        'pdo_mysql'    => [],
        'pdo_oci'      => [],
        'pdo_odbc'     => [],
        'pdo_pgsql'    => [],
        'pdo_sqlite'   => [],
        'pgsql'        => [],
        'phar'         => [],
        'posix'        => [],
        'pspell'       => [],
        'readline'     => [],
        'recode'       => [],
        'reflection'   => [],
        'session'      => [],
        'shmop'        => [],
        'simplexml'    => [],
        'skeleton'     => [],
        'snmp'         => [],
        'soap'         => [],
        'sockets'      => [],
        'spl'          => [],
        'sqlite3'      => [],
        'standard'     => [],
        'sysvmsg'      => [],
        'sysvsem'      => [],
        'sysvshm'      => [],
        'tidy'         => [],
        'tokenizer'    => [],
        'wddx'         => [],
        'xml'          => [],
        'xmlreader'    => [],
        'xmlrpc'       => [],
        'xmlwriter'    => [],
        'xsl'          => [],
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
        return array_key_exists($name, self::EXTENSIONS_MAP);
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

        $raw = self::EXTENSIONS_MAP[$name];

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
}

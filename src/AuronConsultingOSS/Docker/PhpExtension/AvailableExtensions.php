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
        'APC'      => ['packages' => ['php7.0-apcu', 'php7.0-apcu-bc']],
        'cURL'     => ['packages' => ['php7.0-curl']],
        'JSON'     => ['packages' => ['php7.0-json']],
        'MCrypt'   => ['packages' => ['php7.0-mcrypt']],
        'OPCache'  => ['packages' => ['php7.0-opcache']],
        'Readline' => ['packages' => ['php7.0-readline']],
    ];

    /**
     * List of allowed extensions
     */
    const OPTIONAL_EXTENSIONS_MAP = [
        'Memcached'   => ['packages' => ['php7.0-memcached']],
        'MongoDB'     => ['packages' => ['php7.0-mongodb']],
        'MySQL'       => ['packages' => ['php7.0-mysql']],
        'PostgreSQL'  => ['packages' => ['php7.0-pgsql']],
        'SQLite3'     => ['packages' => ['php7.0-sqlite3']],
        'Redis'       => ['packages' => ['php7.0-redis']],
        'bz2'         => ['packages' => ['php7.0-bz2']],
        'dbg'         => ['packages' => ['php7.0-dbg']],
        'Enchant'     => ['packages' => ['php7.0-enchant']],
        'GD'          => ['packages' => ['php7.0-gd']],
        'GMP'         => ['packages' => ['php7.0-gmp']],
        'igbinary'    => ['packages' => ['php7.0-igbinary']],
        'ImageMagick' => ['packages' => ['php7.0-imagick']],
        'IMAP'        => ['packages' => ['php7.0-imap']],
        'Interbase'   => ['packages' => ['php7.0-interbase']],
        'Intl'        => ['packages' => ['php7.0-intl']],
        'LDAP'        => ['packages' => ['php7.0-ldap']],
        'MessagePack' => ['packages' => ['php7.0-msgpack']],
        'ODBC'        => ['packages' => ['php7.0-odbc']],
        'PHPDBG'      => ['packages' => ['php7.0-phpdbg']],
        'PSpell'      => ['packages' => ['php7.0-pspell']],
        'Recode'      => ['packages' => ['php7.0-recode']],
        'SNMP'        => ['packages' => ['php7.0-snmp']],
        'Sybase'      => ['packages' => ['php7.0-sybase']],
        'Tidy'        => ['packages' => ['php7.0-tidy']],
        'XDebug'      => ['packages' => ['php7.0-xdebug']],
        'XMLRPC-EPI'  => ['packages' => ['php7.0-xmlrpc']],
        'XSL'         => ['packages' => ['php7.0-xsl']],

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
     * @throws Exception\NotFoundException
     */
    public static function getPhpExtension(string $name) : PhpExtension
    {
        if (self::isAvailable($name) === false) {
            throw new Exception\NotFoundException(sprintf('PHP extension %s is not available to install', $name));
        }

        $raw = self::getAllExtensions()[$name];

        $extension = new PhpExtension();
        $extension->setName($name);

        foreach ($raw['packages'] ?? [] as $package) {
            $extension->addPackage($package);
        }

        return $extension;
    }

    /**
     * Returns all mandatory php extensions as an array of PhpExtension.
     *
     * @return array
     * @throws Exception\NotFoundException
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

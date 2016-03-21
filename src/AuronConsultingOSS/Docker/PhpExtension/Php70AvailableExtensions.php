<?php
namespace AuronConsultingOSS\Docker\PhpExtension;

/**
 * Extensions available on PHP 7.0.x.
 *
 * @package   AuronConsultingOSS\Docker\PhpExtension
 * @copyright Auron Consulting Ltd
 */
class Php70AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getMandatoryExtensionsMap() : array
    {
        return [
            'APC'      => ['packages' => ['php7.0-apcu', 'php7.0-apcu-bc']],
            'cURL'     => ['packages' => ['php7.0-curl']],
            'JSON'     => ['packages' => ['php7.0-json']],
            'MCrypt'   => ['packages' => ['php7.0-mcrypt']],
            'OPCache'  => ['packages' => ['php7.0-opcache']],
            'Readline' => ['packages' => ['php7.0-readline']],
        ];
    }

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getOptionalExtensionsMap() : array
    {
        return [
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
    }
}

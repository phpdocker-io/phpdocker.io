<?php
declare(strict_types=1);
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

namespace PHPDocker\PhpExtension;

/**
 * Extensions available on PHP 7.0.x.
 *
 * @package PHPDocker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class Php70AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'APC'      => ['packages' => ['php7.0-apcu', 'php7.0-apcu-bc']],
            'cURL'     => ['packages' => ['php7.0-curl']],
            'JSON'     => ['packages' => ['php7.0-json']],
            'MBSTRING' => ['packages' => ['php7.0-mbstring']],
            'MCrypt'   => ['packages' => ['php7.0-mcrypt']],
            'OPCache'  => ['packages' => ['php7.0-opcache']],
            'Readline' => ['packages' => ['php7.0-readline']],
            'XML'      => ['packages' => ['php7.0-xml']],
            'Zip'      => ['packages' => ['php7.0-zip']],
        ];
    }

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'Memcached'           => ['packages' => ['php7.0-memcached']],
            'MongoDB'             => ['packages' => ['php7.0-mongodb']],
            'MySQL'               => ['packages' => ['php7.0-mysql']],
            'PostgreSQL'          => ['packages' => ['php7.0-pgsql']],
            'Redis'               => ['packages' => ['php7.0-redis']],
            'SQLite3'             => ['packages' => ['php7.0-sqlite3']],
            'bz2'                 => ['packages' => ['php7.0-bz2']],
            'dbg'                 => ['packages' => ['php7.0-dbg']],
            'Enchant'             => ['packages' => ['php7.0-enchant']],
            'GD'                  => ['packages' => ['php7.0-gd']],
            'Geoip'               => ['packages' => ['php7.0-geoip']],
            'GMP'                 => ['packages' => ['php7.0-gmp']],
            'igbinary'            => ['packages' => ['php7.0-igbinary']],
            'ImageMagick'         => ['packages' => ['php7.0-imagick']],
            'IMAP'                => ['packages' => ['php7.0-imap']],
            'Interbase'           => ['packages' => ['php7.0-interbase']],
            'Intl'                => ['packages' => ['php7.0-intl']],
            'LDAP'                => ['packages' => ['php7.0-ldap']],
            'MessagePack/msgpack' => ['packages' => ['php7.0-msgpack']],
            'ODBC'                => ['packages' => ['php7.0-odbc']],
            'PHPDBG'              => ['packages' => ['php7.0-phpdbg']],
            'PSpell'              => ['packages' => ['php7.0-pspell']],
            'Recode'              => ['packages' => ['php7.0-recode']],
            'SNMP'                => ['packages' => ['php7.0-snmp']],
            'SOAP'                => ['packages' => ['php7.0-soap']],
            'SSH2'                => ['packages' => ['php7.0-ssh2']],
            'Sybase'              => ['packages' => ['php7.0-sybase']],
            'Tidy'                => ['packages' => ['php7.0-tidy']],
            'XDebug'              => ['packages' => ['php7.0-xdebug']],
            'XMLRPC-EPI'          => ['packages' => ['php7.0-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.0-xsl']],
        ];
    }
}

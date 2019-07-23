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
 * Extensions available on PHP 7.2.x.
 *
 * @package PHPDocker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class Php72AvailableExtensions extends BaseAvailableExtensions
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
            'cURL'     => ['packages' => ['php7.2-curl']],
            'JSON'     => ['packages' => ['php7.2-json']],
            'MBSTRING' => ['packages' => ['php7.2-mbstring']],
            'OPCache'  => ['packages' => ['php7.2-opcache']],
            'Readline' => ['packages' => ['php7.2-readline']],
            'Sodium'   => ['packages' => ['php7.2-sodium']],
            'XML'      => ['packages' => ['php7.2-xml']],
            'Zip'      => ['packages' => ['php7.2-zip']],
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
            'Memcached'           => ['packages' => ['php-memcached']],
            'MySQL'               => ['packages' => ['php7.2-mysql']],
            'PostgreSQL'          => ['packages' => ['php7.2-pgsql']],
            'Redis'               => ['packages' => ['php-redis']],
            'SQLite3'             => ['packages' => ['php7.2-sqlite3']],
            'XDebug'              => ['packages' => ['php-xdebug']],
            'Bcmath'              => ['packages' => ['php7.2-bcmath']],
            'bz2'                 => ['packages' => ['php7.2-bz2']],
            'DBA'                 => ['packages' => ['php7.2-dba']],
            'Enchant'             => ['packages' => ['php7.2-enchant']],
            'GD'                  => ['packages' => ['php7.2-gd']],
            'Gearman'             => ['packages' => ['php-gearman']],
            'GMP'                 => ['packages' => ['php7.2-gmp']],
            'igbinary'            => ['packages' => ['php-igbinary']],
            'ImageMagick'         => ['packages' => ['php-imagick']],
            'IMAP'                => ['packages' => ['php7.2-imap']],
            'Interbase'           => ['packages' => ['php7.2-interbase']],
            'Intl'                => ['packages' => ['php7.2-intl']],
            'LDAP'                => ['packages' => ['php7.2-ldap']],
            'MongoDB'             => ['packages' => ['php-mongodb']],
            'MessagePack/msgpack' => ['packages' => ['php-msgpack']],
            'ODBC'                => ['packages' => ['php7.2-odbc']],
            'PHPDBG'              => ['packages' => ['php7.2-phpdbg']],
            'PSpell'              => ['packages' => ['php7.2-pspell']],
            'raphf'               => ['packages' => ['php-raphf']],
            'Recode'              => ['packages' => ['php7.2-recode']],
            'SNMP'                => ['packages' => ['php7.2-snmp']],
            'SOAP'                => ['packages' => ['php7.2-soap']],
            'SSH2'                => ['packages' => ['php-ssh2']],
            'Sybase'              => ['packages' => ['php7.2-sybase']],
            'Tideways'            => ['packages' => ['php-tideways']],
            'Tidy'                => ['packages' => ['php7.2-tidy']],
            'XMLRPC-EPI'          => ['packages' => ['php7.2-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.2-xsl']],
            'YAML'                => ['packages' => ['php-yaml']],
            'ZeroMQ'              => ['packages' => ['php-zmq']],

            // Disabled (not yet on php72 or broken)

            // libgearman broken (libgearman8 not on repos)
            //

            // Installs php56
            //            'Xhprof'      => ['packages' => ['php-xhprof']],

        ];
    }
}

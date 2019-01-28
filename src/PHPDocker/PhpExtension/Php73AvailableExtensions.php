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

namespace PHPDocker\PhpExtension;

/**
 * Extensions available on PHP .x.
 *
 * @package PHPDocker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class Php73AvailableExtensions extends BaseAvailableExtensions
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
            'cURL'     => ['packages' => ['php-curl']],
            'JSON'     => ['packages' => ['php-json']],
            'MBSTRING' => ['packages' => ['php-mbstring']],
            'OPCache'  => ['packages' => ['php-opcache']],
            'Readline' => ['packages' => ['php-readline']],
            'Sodium'   => ['packages' => ['php-sodium']],
            'XML'      => ['packages' => ['php-xml']],
            'Zip'      => ['packages' => ['php-zip']],
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
            'Memcached'   => ['packages' => ['php-memcached']],
            'MySQL'       => ['packages' => ['php7.3-mysql']],
            'PostgreSQL'  => ['packages' => ['php7.3-pgsql']],
            'Redis'       => ['packages' => ['php-redis']],
            'SQLite3'     => ['packages' => ['php7.3-sqlite3']],
//            'XDebug'      => ['packages' => ['php-xdebug']],
            'Bcmath'      => ['packages' => ['php7.3-bcmath']],
            'bz2'         => ['packages' => ['php7.3-bz2']],
            'DBA'         => ['packages' => ['php7.3-dba']],
            'Enchant'     => ['packages' => ['php7.3-enchant']],
            'GD'          => ['packages' => ['php7.3-gd']],
            'Gearman'     => ['packages' => ['php-gearman']],
            'GMP'         => ['packages' => ['php7.3-gmp']],
            'igbinary'    => ['packages' => ['php-igbinary']],
            'ImageMagick' => ['packages' => ['php-imagick']],
            'IMAP'        => ['packages' => ['php7.3-imap']],
            'Interbase'   => ['packages' => ['php7.3-interbase']],
            'Intl'        => ['packages' => ['php7.3-intl']],
            'LDAP'        => ['packages' => ['php7.3-ldap']],
            'MongoDB'     => ['packages' => ['php-mongodb']],
            'MessagePack' => ['packages' => ['php-msgpack']],
            'ODBC'        => ['packages' => ['php7.3-odbc']],
            'PHPDBG'      => ['packages' => ['php7.3-phpdbg']],
            'PSpell'      => ['packages' => ['php7.3-pspell']],
            'raphf'       => ['packages' => ['php-raphf']],
            'Recode'      => ['packages' => ['php7.3-recode']],
            'SNMP'        => ['packages' => ['php7.3-snmp']],
            'SOAP'        => ['packages' => ['php7.3-soap']],
            'SSH2'        => ['packages' => ['php-ssh2']],
            'Sybase'      => ['packages' => ['php7.3-sybase']],
            'Tideways'    => ['packages' => ['php-tideways']],
            'Tidy'        => ['packages' => ['php7.3-tidy']],
            'XMLRPC-EPI'  => ['packages' => ['php7.3-xmlrpc']],
            'XSL'         => ['packages' => ['php7.3-xsl']],
            'YAML'        => ['packages' => ['php-yaml']],
            'ZeroMQ'      => ['packages' => ['php-zmq']],

            // Disabled (not yet on php73 or broken)
            
            // Installs php56
            //            'Xhprof'      => ['packages' => ['php-xhprof']],
        ];
    }
}

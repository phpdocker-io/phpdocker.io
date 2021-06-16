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
 * Extensions available on PHP 7.2.x.
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
            'Bcmath'              => ['packages' => ['php7.2-bcmath']],
            'bzip2'               => ['packages' => ['php7.2-bz2']],
            'DBA'                 => ['packages' => ['php7.2-dba']],
            'Enchant'             => ['packages' => ['php7.2-enchant']],
            'GD'                  => ['packages' => ['php7.2-gd']],
            'GMP'                 => ['packages' => ['php7.2-gmp']],
            'Gearman'             => ['packages' => ['php7.2-gearman']],
            'igbinary'            => ['packages' => ['php7.2-igbinary']],
            'IMAP'                => ['packages' => ['php7.2-imap']],
            'ImageMagick'         => ['packages' => ['php7.2-imagick']],
            'Interbase'           => ['packages' => ['php7.2-interbase']],
            'Intl'                => ['packages' => ['php7.2-intl']],
            'LDAP'                => ['packages' => ['php7.2-ldap']],
            'Memcached'           => ['packages' => ['php7.2-memcached']],
            'MessagePack/msgpack' => ['packages' => ['php7.2-msgpack']],
            'MongoDB'             => ['packages' => ['php7.2-mongodb']],
            'MySQL'               => ['packages' => ['php7.2-mysql']],
            'ODBC'                => ['packages' => ['php7.2-odbc']],
            'PHPDBG'              => ['packages' => ['php7.2-phpdbg']],
            'PSpell'              => ['packages' => ['php7.2-pspell']],
            'Phalcon3'            => ['packages' => ['php7.2-phalcon3']],
            'Phalcon4'            => ['packages' => ['php7.2-phalcon4', 'php7.2-psr']],
            'PostgreSQL'          => ['packages' => ['php7.2-pgsql']],
            'raphf'               => ['packages' => ['php7.2-raphf']],
            'Recode'              => ['packages' => ['php7.2-recode']],
            'Redis'               => ['packages' => ['php7.2-redis']],
            'SNMP'                => ['packages' => ['php7.2-snmp']],
            'SOAP'                => ['packages' => ['php7.2-soap']],
            'SQLite3'             => ['packages' => ['php7.2-sqlite3']],
            'SSH2'                => ['packages' => ['php7.2-ssh2']],
            'Sybase'              => ['packages' => ['php7.2-sybase']],
            'Tideways'            => ['packages' => ['php7.2-tideways']],
            'Tidy'                => ['packages' => ['php7.2-tidy']],
            'XDebug'              => ['packages' => ['php7.2-xdebug']],
            'XMLRPC-EPI'          => ['packages' => ['php7.2-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.2-xsl']],
            'Xhprof'              => ['packages' => ['php7.2-xhprof']],
            'YAML'                => ['packages' => ['php7.2-yaml']],
            'ZeroMQ'              => ['packages' => ['php7.2-zmq']],
        ];
    }
}

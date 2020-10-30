<?php
/**
 * Copyright 2019 Luis Alberto Pabón Flores
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
 *
 */

namespace PHPDocker\PhpExtension;

class Php74AvailableExtensions extends BaseAvailableExtensions
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
            'cURL'     => ['packages' => ['php7.4-curl']],
            'JSON'     => ['packages' => ['php7.4-json']],
            'MBSTRING' => ['packages' => ['php7.4-mbstring']],
            'OPCache'  => ['packages' => ['php7.4-opcache']],
            'Readline' => ['packages' => ['php7.4-readline']],
            'XML'      => ['packages' => ['php7.4-xml']],
            'Zip'      => ['packages' => ['php7.4-zip']],
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
            'Memcached'           => ['packages' => ['php7.4-memcached']],
            'MySQL'               => ['packages' => ['php7.4-mysql']],
            'PostgreSQL'          => ['packages' => ['php7.4-pgsql']],
            'Redis'               => ['packages' => ['php7.4-redis']],
            'SQLite3'             => ['packages' => ['php7.4-sqlite3']],
            'XDebug'              => ['packages' => ['php7.4-xdebug']],
            'Bcmath'              => ['packages' => ['php7.4-bcmath']],
            'bz2'                 => ['packages' => ['php7.4-bz2']],
            'DBA'                 => ['packages' => ['php7.4-dba']],
            'Enchant'             => ['packages' => ['php7.4-enchant']],
            'GD'                  => ['packages' => ['php7.4-gd']],
            'Gearman'             => ['packages' => ['php7.4-gearman']],
            'GMP'                 => ['packages' => ['php7.4-gmp']],
            'igbinary'            => ['packages' => ['php7.4-igbinary']],
            'ImageMagick'         => ['packages' => ['php7.4-imagick']],
            'IMAP'                => ['packages' => ['php7.4-imap']],
            'Interbase'           => ['packages' => ['php7.4-interbase']],
            'Intl'                => ['packages' => ['php7.4-intl']],
            'LDAP'                => ['packages' => ['php7.4-ldap']],
            'MongoDB'             => ['packages' => ['php7.4-mongodb']],
            'MessagePack/msgpack' => ['packages' => ['php7.4-msgpack']],
            'ODBC'                => ['packages' => ['php7.4-odbc']],
            'PHPDBG'              => ['packages' => ['php7.4-phpdbg']],
            'PSpell'              => ['packages' => ['php7.4-pspell']],
            'raphf'               => ['packages' => ['php7.4-raphf']],
            'SNMP'                => ['packages' => ['php7.4-snmp']],
            'SOAP'                => ['packages' => ['php7.4-soap']],
            'SSH2'                => ['packages' => ['php7.4-ssh2']],
            'Sybase'              => ['packages' => ['php7.4-sybase']],
            'Tideways'            => ['packages' => ['php7.4-tideways']],
            'Tidy'                => ['packages' => ['php7.4-tidy']],
            'XMLRPC-EPI'          => ['packages' => ['php7.4-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.4-xsl']],
            'Xhprof'              => ['packages' => ['php7.4-xhprof']],
            'YAML'                => ['packages' => ['php7.4-yaml']],
            'ZeroMQ'              => ['packages' => ['php7.4-zmq']],
        ];
    }
}

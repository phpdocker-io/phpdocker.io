<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

/**
 * Copyright 2016 Luis Alberto Pabón Flores
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
 * Extensions available on PHP 7.3.x
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
            'cURL'     => ['packages' => ['php7.3-curl']],
            'JSON'     => ['packages' => ['php7.3-json']],
            'MBSTRING' => ['packages' => ['php7.3-mbstring']],
            'OPCache'  => ['packages' => ['php7.3-opcache']],
            'Readline' => ['packages' => ['php7.3-readline']],
            'XML'      => ['packages' => ['php7.3-xml']],
            'Zip'      => ['packages' => ['php7.3-zip']],
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
            'Bcmath'              => ['packages' => ['php7.3-bcmath']],
            'bzip2'               => ['packages' => ['php7.3-bz2']],
            'DBA'                 => ['packages' => ['php7.3-dba']],
            'Enchant'             => ['packages' => ['php7.3-enchant']],
            'GD'                  => ['packages' => ['php7.3-gd']],
            'GMP'                 => ['packages' => ['php7.3-gmp']],
            'Gearman'             => ['packages' => ['php7.3-gearman']],
            'igbinary'            => ['packages' => ['php7.3-igbinary']],
            'IMAP'                => ['packages' => ['php7.3-imap']],
            'ImageMagick'         => ['packages' => ['php7.3-imagick']],
            'Interbase'           => ['packages' => ['php7.3-interbase']],
            'Intl'                => ['packages' => ['php7.3-intl']],
            'LDAP'                => ['packages' => ['php7.3-ldap']],
            'Memcached'           => ['packages' => ['php7.3-memcached']],
            'MessagePack/msgpack' => ['packages' => ['php7.3-msgpack']],
            'MongoDB'             => ['packages' => ['php7.3-mongodb']],
            'MySQL'               => ['packages' => ['php7.3-mysql']],
            'ODBC'                => ['packages' => ['php7.3-odbc']],
            'PHPDBG'              => ['packages' => ['php7.3-phpdbg']],
            'PSpell'              => ['packages' => ['php7.3-pspell']],
            'Phalcon3'            => ['packages' => ['php7.3-phalcon3']],
            'Phalcon4'            => ['packages' => ['php7.3-phalcon4', 'php7.3-psr']],
            'PostgreSQL'          => ['packages' => ['php7.3-pgsql']],
            'raphf'               => ['packages' => ['php7.3-raphf']],
            'Recode'              => ['packages' => ['php7.3-recode']],
            'Redis'               => ['packages' => ['php7.3-redis']],
            'SNMP'                => ['packages' => ['php7.3-snmp']],
            'SOAP'                => ['packages' => ['php7.3-soap']],
            'SQLite3'             => ['packages' => ['php7.3-sqlite3']],
            'SSH2'                => ['packages' => ['php7.3-ssh2']],
            'Sybase'              => ['packages' => ['php7.3-sybase']],
            'Tideways'            => ['packages' => ['php7.3-tideways']],
            'Tidy'                => ['packages' => ['php7.3-tidy']],
            'XDebug'              => ['packages' => ['php7.3-xdebug']],
            'XMLRPC-EPI'          => ['packages' => ['php7.3-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.3-xsl']],
            'Xhprof'              => ['packages' => ['php7.3-xhprof']],
            'YAML'                => ['packages' => ['php7.3-yaml']],
            'ZeroMQ'              => ['packages' => ['php7.3-zmq']],
        ];
    }
}

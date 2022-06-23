<?php
declare(strict_types=1);

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

namespace App\PHPDocker\PhpExtension;

class Php74AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
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
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                => ['packages' => ['php7.4-amqp']],
            'Bcmath'              => ['packages' => ['php7.4-bcmath']],
            'bzip2'               => ['packages' => ['php7.4-bz2']],
            'DBA'                 => ['packages' => ['php7.4-dba']],
            'Enchant'             => ['packages' => ['php7.4-enchant']],
            'GD'                  => ['packages' => ['php7.4-gd']],
            'GMP'                 => ['packages' => ['php7.4-gmp']],
            'Gearman'             => ['packages' => ['php7.4-gearman']],
            'igbinary'            => ['packages' => ['php7.4-igbinary']],
            'IMAP'                => ['packages' => ['php7.4-imap']],
            'ImageMagick'         => ['packages' => ['php7.4-imagick']],
            'Interbase'           => ['packages' => ['php7.4-interbase']],
            'Intl'                => ['packages' => ['php7.4-intl']],
            'LDAP'                => ['packages' => ['php7.4-ldap']],
            'Memcached'           => ['packages' => ['php7.4-memcached']],
            'MessagePack/msgpack' => ['packages' => ['php7.4-msgpack']],
            'MongoDB'             => ['packages' => ['php7.4-mongodb']],
            'MySQL'               => ['packages' => ['php7.4-mysql']],
            'ODBC'                => ['packages' => ['php7.4-odbc']],
            'PHPDBG'              => ['packages' => ['php7.4-phpdbg']],
            'PSpell'              => ['packages' => ['php7.4-pspell']],
            'Phalcon4'            => ['packages' => ['php7.4-phalcon4', 'php7.4-psr']],
            'PostgreSQL'          => ['packages' => ['php7.4-pgsql']],
            'raphf'               => ['packages' => ['php7.4-raphf']],
            'Redis'               => ['packages' => ['php7.4-redis']],
            'SNMP'                => ['packages' => ['php7.4-snmp']],
            'SOAP'                => ['packages' => ['php7.4-soap']],
            'SQLite3'             => ['packages' => ['php7.4-sqlite3']],
            'SSH2'                => ['packages' => ['php7.4-ssh2']],
            'Sybase'              => ['packages' => ['php7.4-sybase']],
            'Tideways'            => ['packages' => ['php7.4-tideways']],
            'Tidy'                => ['packages' => ['php7.4-tidy']],
            'XDebug'              => ['packages' => ['php7.4-xdebug']],
            'XMLRPC-EPI'          => ['packages' => ['php7.4-xmlrpc']],
            'XSL'                 => ['packages' => ['php7.4-xsl']],
            'Xhprof'              => ['packages' => ['php7.4-xhprof']],
            'YAML'                => ['packages' => ['php7.4-yaml']],
            'ZeroMQ'              => ['packages' => ['php7.4-zmq']],
        ];
    }
}

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

class Php80AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['packages' => ['php8.0-curl']],
            'MBSTRING' => ['packages' => ['php8.0-mbstring']],
            'OPCache'  => ['packages' => ['php8.0-opcache']],
            'Readline' => ['packages' => ['php8.0-readline']],
            'XML'      => ['packages' => ['php8.0-xml']],
            'Zip'      => ['packages' => ['php8.0-zip']],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['packages' => ['php8.0-amqp']],
            'AST'                         => ['packages' => ['php8.0-ast']],
            'Bcmath'                      => ['packages' => ['php8.0-bcmath']],
            'bzip2'                       => ['packages' => ['php8.0-bz2']],
            'CGI'                         => ['packages' => ['php8.0-cgi']],
            'DBA'                         => ['packages' => ['php8.0-dba']],
            'Decimal'                     => ['packages' => ['php8.0-decimal']],
            'DS (Data Structures)'        => ['packages' => ['php8.0-ds']],
            'Enchant'                     => ['packages' => ['php8.0-enchant']],
            'GD'                          => ['packages' => ['php8.0-gd']],
            'Gearman'                     => ['packages' => ['php8.0-gearman']],
            'Gmagick (GraphicsMagick)'    => ['packages' => ['php8.0-gmagick']],
            'GMP'                         => ['packages' => ['php8.0-gmp']],
            'GNUPG'                       => ['packages' => ['php8.0-gnupg']],
            'GRPC'                        => ['packages' => ['php8.0-grpc']],
            'HTTP'                        => ['packages' => ['php8.0-http']],
            'igbinary'                    => ['packages' => ['php8.0-igbinary']],
            'ImageMagick'                 => ['packages' => ['php8.0-imagick']],
            'IMAP'                        => ['packages' => ['php8.0-imap']],
            'Inotify'                     => ['packages' => ['php8.0-inotify']],
            'Interbase'                   => ['packages' => ['php8.0-interbase']],
            'Intl (Internationalisation)' => ['packages' => ['php8.0-intl']],
            'LDAP'                        => ['packages' => ['php8.0-ldap']],
            'LZ4'                         => ['packages' => ['php8.0-lz4']],
            'Mailparse'                   => ['packages' => ['php8.0-mailparse']],
            'MaxMind DB'                  => ['packages' => ['php8.0-maxminddb']],
            'mcrypt'                      => ['packages' => ['php8.0-mcrypt']],
            'Memcache'                    => ['packages' => ['php8.0-memcache']],
            'Memcached'                   => ['packages' => ['php8.0-memcached']],
            'MongoDB'                     => ['packages' => ['php8.0-mongodb']],
            'MessagePack'                 => ['packages' => ['php8.0-msgpack']],
            'MySQL'                       => ['packages' => ['php8.0-mysql']],
            'OAuth'                       => ['packages' => ['php8.0-oauth']],
            'ODBC'                        => ['packages' => ['php8.0-odbc']],
            'Pcov'                        => ['packages' => ['php8.0-pcov']],
            'PostgreSQL'                  => ['packages' => ['php8.0-pgsql']],
            'PHPDBG'                      => ['packages' => ['php8.0-phpdbg']],
            'Protobuf'                    => ['packages' => ['php8.0-protobuf']],
            'pspell'                      => ['packages' => ['php8.0-pspell']],
            'PSR'                         => ['packages' => ['php8.0-psr']],
            'raphf'                       => ['packages' => ['php8.0-raphf']],
            'Redis'                       => ['packages' => ['php8.0-redis']],
            'rrd'                         => ['packages' => ['php8.0-rrd']],
            'Samba Client'                => ['packages' => ['php8.0-smbclient']],
            'SNMP'                        => ['packages' => ['php8.0-snmp']],
            'SOAP'                        => ['packages' => ['php8.0-soap']],
            'Solr'                        => ['packages' => ['php8.0-solr']],
            'SQLite3'                     => ['packages' => ['php8.0-sqlite3']],
            'ssh2'                        => ['packages' => ['php8.0-ssh2']],
            'Swoole'                      => ['packages' => ['php8.0-swoole']],
            'Sybase'                      => ['packages' => ['php8.0-sybase']],
            'Tidy'                        => ['packages' => ['php8.0-tidy']],
            'UUID'                        => ['packages' => ['php8.0-uuid']],
            'vips'                        => ['packages' => ['php8.0-vips']],
            'Xdebug'                      => ['packages' => ['php8.0-xdebug']],
            'Xhprof'                      => ['packages' => ['php8.0-xhprof']],
            'XMLRPC'                      => ['packages' => ['php8.0-xmlrpc']],
            'XSL'                         => ['packages' => ['php8.0-xsl']],
            'Yac'                         => ['packages' => ['php8.0-yac']],
            'YAML'                        => ['packages' => ['php8.0-yaml']],
            'ZMQ (ZeroMQ)'                => ['packages' => ['php8.0-zmq']],
            'zstd (Zstandard)'            => ['packages' => ['php8.0-zstd']],
        ];
    }
}

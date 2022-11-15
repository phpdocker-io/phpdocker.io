<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
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

class Php82AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['packages' => ['php8.2-curl']],
            'MBSTRING' => ['packages' => ['php8.2-mbstring']],
            'OPCache'  => ['packages' => ['php8.2-opcache']],
            'Readline' => ['packages' => ['php8.2-readline']],
            'XML'      => ['packages' => ['php8.2-xml']],
            'Zip'      => ['packages' => ['php8.2-zip']],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['packages' => ['php8.2-amqp']],
            'AST'                         => ['packages' => ['php8.2-ast']],
            'Bcmath'                      => ['packages' => ['php8.2-bcmath']],
            'bzip2'                       => ['packages' => ['php8.2-bz2']],
            'CGI'                         => ['packages' => ['php8.2-cgi']],
            'DBA'                         => ['packages' => ['php8.2-dba']],
            'Decimal'                     => ['packages' => ['php8.2-decimal']],
            'DS (Data Structures)'        => ['packages' => ['php8.2-ds']],
            'Enchant'                     => ['packages' => ['php8.2-enchant']],
            'GD'                          => ['packages' => ['php8.2-gd']],
            'Gearman'                     => ['packages' => ['php8.2-gearman']],
            'Gmagick (GraphicsMagick)'    => ['packages' => ['php8.2-gmagick']],
            'GMP'                         => ['packages' => ['php8.2-gmp']],
            'GNUPG'                       => ['packages' => ['php8.2-gnupg']],
            'GRPC'                        => ['packages' => ['php8.2-grpc']],
            'HTTP'                        => ['packages' => ['php8.2-http']],
            'igbinary'                    => ['packages' => ['php8.2-igbinary']],
            'ImageMagick'                 => ['packages' => ['php8.2-imagick']],
            'IMAP'                        => ['packages' => ['php8.2-imap']],
            'Inotify'                     => ['packages' => ['php8.2-inotify']],
            'Interbase'                   => ['packages' => ['php8.2-interbase']],
            'Intl (Internationalisation)' => ['packages' => ['php8.2-intl']],
            'LDAP'                        => ['packages' => ['php8.2-ldap']],
            'LZ4'                         => ['packages' => ['php8.2-lz4']],
            'Mailparse'                   => ['packages' => ['php8.2-mailparse']],
            'MaxMind DB'                  => ['packages' => ['php8.2-maxminddb']],
            'mcrypt'                      => ['packages' => ['php8.2-mcrypt']],
            'Memcache'                    => ['packages' => ['php8.2-memcache']],
            'Memcached'                   => ['packages' => ['php8.2-memcached']],
            'MongoDB'                     => ['packages' => ['php8.2-mongodb']],
            'MessagePack'                 => ['packages' => ['php8.2-msgpack']],
            'MySQL'                       => ['packages' => ['php8.2-mysql']],
            'OAuth'                       => ['packages' => ['php8.2-oauth']],
            'ODBC'                        => ['packages' => ['php8.2-odbc']],
            'Pcov'                        => ['packages' => ['php8.2-pcov']],
            'PostgreSQL'                  => ['packages' => ['php8.2-pgsql']],
            'PHPDBG'                      => ['packages' => ['php8.2-phpdbg']],
            'Protobuf'                    => ['packages' => ['php8.2-protobuf']],
            'pspell'                      => ['packages' => ['php8.2-pspell']],
            'PSR'                         => ['packages' => ['php8.2-psr']],
            'raphf'                       => ['packages' => ['php8.2-raphf']],
            'Redis'                       => ['packages' => ['php8.2-redis']],
            'rrd'                         => ['packages' => ['php8.2-rrd']],
            'Samba Client'                => ['packages' => ['php8.2-smbclient']],
            'SNMP'                        => ['packages' => ['php8.2-snmp']],
            'SOAP'                        => ['packages' => ['php8.2-soap']],
            'Solr'                        => ['packages' => ['php8.2-solr']],
            'SQLite3'                     => ['packages' => ['php8.2-sqlite3']],
            'ssh2'                        => ['packages' => ['php8.2-ssh2']],
            'Swoole'                      => ['packages' => ['php8.2-swoole']],
            'Sybase'                      => ['packages' => ['php8.2-sybase']],
            'Tidy'                        => ['packages' => ['php8.2-tidy']],
            'UUID'                        => ['packages' => ['php8.2-uuid']],
            'vips'                        => ['packages' => ['php8.2-vips']],
            'Xdebug'                      => ['packages' => ['php8.2-xdebug']],
            'Xhprof'                      => ['packages' => ['php8.2-xhprof']],
            'XMLRPC'                      => ['packages' => ['php8.2-xmlrpc']],
            'XSL'                         => ['packages' => ['php8.2-xsl']],
            'Yac'                         => ['packages' => ['php8.2-yac']],
            'YAML'                        => ['packages' => ['php8.2-yaml']],
            'ZMQ (ZeroMQ)'                => ['packages' => ['php8.2-zmq']],
            'zstd (Zstandard)'            => ['packages' => ['php8.2-zstd']],
        ];
    }
}

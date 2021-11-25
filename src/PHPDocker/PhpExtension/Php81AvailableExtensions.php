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

class Php81AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['packages' => ['php8.1-curl']],
            'MBSTRING' => ['packages' => ['php8.1-mbstring']],
            'OPCache'  => ['packages' => ['php8.1-opcache']],
            'Readline' => ['packages' => ['php8.1-readline']],
            'XML'      => ['packages' => ['php8.1-xml']],
            'Zip'      => ['packages' => ['php8.1-zip']],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['packages' => ['php8.1-amqp']],
            'AST'                         => ['packages' => ['php8.1-ast']],
            'Bcmath'                      => ['packages' => ['php8.1-bcmath']],
            'bzip2'                       => ['packages' => ['php8.1-bz2']],
            'CGI'                         => ['packages' => ['php8.1-cgi']],
            'DBA'                         => ['packages' => ['php8.1-dba']],
            'Decimal'                     => ['packages' => ['php8.1-decimal']],
            'DS (Data Structures)'        => ['packages' => ['php8.1-ds']],
            'Enchant'                     => ['packages' => ['php8.1-enchant']],
            'GD'                          => ['packages' => ['php8.1-gd']],
            'Gearman'                     => ['packages' => ['php8.1-gearman']],
            'Gmagick (GraphicsMagick)'    => ['packages' => ['php8.1-gmagick']],
            'GMP'                         => ['packages' => ['php8.1-gmp']],
            'GNUPG'                       => ['packages' => ['php8.1-gnupg']],
            'GRPC'                        => ['packages' => ['php8.1-grpc']],
            'HTTP'                        => ['packages' => ['php8.1-http']],
            'igbinary'                    => ['packages' => ['php8.1-igbinary']],
            'ImageMagick'                 => ['packages' => ['php8.1-imagick']],
            'IMAP'                        => ['packages' => ['php8.1-imap']],
            'Inotify'                     => ['packages' => ['php8.1-inotify']],
            'Interbase'                   => ['packages' => ['php8.1-interbase']],
            'Intl (Internationalisation)' => ['packages' => ['php8.1-intl']],
            'LDAP'                        => ['packages' => ['php8.1-ldap']],
            'LZ4'                         => ['packages' => ['php8.1-lz4']],
            'Mailparse'                   => ['packages' => ['php8.1-mailparse']],
            'MaxMind DB'                  => ['packages' => ['php8.1-maxminddb']],
            'mcrypt'                      => ['packages' => ['php8.1-mcrypt']],
            'Memcache'                    => ['packages' => ['php8.1-memcache']],
            'Memcached'                   => ['packages' => ['php8.1-memcached']],
            'MongoDB'                     => ['packages' => ['php8.1-mongodb']],
            'MessagePack'                 => ['packages' => ['php8.1-msgpack']],
            'MySQL'                       => ['packages' => ['php8.1-mysql']],
            'OAuth'                       => ['packages' => ['php8.1-oauth']],
            'ODBC'                        => ['packages' => ['php8.1-odbc']],
            'Pcov'                        => ['packages' => ['php8.1-pcov']],
            'PostgreSQL'                  => ['packages' => ['php8.1-pgsql']],
            'PHPDBG'                      => ['packages' => ['php8.1-phpdbg']],
            'Protobuf'                    => ['packages' => ['php8.1-protobuf']],
            'pspell'                      => ['packages' => ['php8.1-pspell']],
            'PSR'                         => ['packages' => ['php8.1-psr']],
            'raphf'                       => ['packages' => ['php8.1-raphf']],
            'Redis'                       => ['packages' => ['php8.1-redis']],
            'rrd'                         => ['packages' => ['php8.1-rrd']],
            'Samba Client'                => ['packages' => ['php8.1-smbclient']],
            'SNMP'                        => ['packages' => ['php8.1-snmp']],
            'SOAP'                        => ['packages' => ['php8.1-soap']],
            'Solr'                        => ['packages' => ['php8.1-solr']],
            'SQLite3'                     => ['packages' => ['php8.1-sqlite3']],
            'ssh2'                        => ['packages' => ['php8.1-ssh2']],
            'Swoole'                      => ['packages' => ['php8.1-swoole']],
            'Sybase'                      => ['packages' => ['php8.1-sybase']],
            'Tidy'                        => ['packages' => ['php8.1-tidy']],
            'UUID'                        => ['packages' => ['php8.1-uuid']],
            'vips'                        => ['packages' => ['php8.1-vips']],
            'Xdebug'                      => ['packages' => ['php8.1-xdebug']],
            'Xhprof'                      => ['packages' => ['php8.1-xhprof']],
            'XMLRPC'                      => ['packages' => ['php8.1-xmlrpc']],
            'XSL'                         => ['packages' => ['php8.1-xsl']],
            'Yac'                         => ['packages' => ['php8.1-yac']],
            'YAML'                        => ['packages' => ['php8.1-yaml']],
            'ZMQ (ZeroMQ)'                => ['packages' => ['php8.1-zmq']],
            'zstd (Zstandard)'            => ['packages' => ['php8.1-zstd']],
        ];
    }
}

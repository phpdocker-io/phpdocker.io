<?php
declare(strict_types=1);
/**
 * Copyright 2023 Luis Alberto Pabón Flores
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

class Php83AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['packages' => ['php8.3-curl']],
            'MBSTRING' => ['packages' => ['php8.3-mbstring']],
            'OPCache'  => ['packages' => ['php8.3-opcache']],
            'Readline' => ['packages' => ['php8.3-readline']],
            'XML'      => ['packages' => ['php8.3-xml']],
            'Zip'      => ['packages' => ['php8.3-zip']],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['packages' => ['php8.3-amqp']],
            'AST'                         => ['packages' => ['php8.3-ast']],
            'Bcmath'                      => ['packages' => ['php8.3-bcmath']],
            'bzip2'                       => ['packages' => ['php8.3-bz2']],
            'CGI'                         => ['packages' => ['php8.3-cgi']],
            'DBA'                         => ['packages' => ['php8.3-dba']],
            'Decimal'                     => ['packages' => ['php8.3-decimal']],
            'DS (Data Structures)'        => ['packages' => ['php8.3-ds']],
            'Enchant'                     => ['packages' => ['php8.3-enchant']],
            'GD'                          => ['packages' => ['php8.3-gd']],
            'Gearman'                     => ['packages' => ['php8.3-gearman']],
            'Gmagick (GraphicsMagick)'    => ['packages' => ['php8.3-gmagick']],
            'GMP'                         => ['packages' => ['php8.3-gmp']],
            'GNUPG'                       => ['packages' => ['php8.3-gnupg']],
            'GRPC'                        => ['packages' => ['php8.3-grpc']],
            'HTTP'                        => ['packages' => ['php8.3-http']],
            'igbinary'                    => ['packages' => ['php8.3-igbinary']],
            'ImageMagick'                 => ['packages' => ['php8.3-imagick']],
            'IMAP'                        => ['packages' => ['php8.3-imap']],
            'Inotify'                     => ['packages' => ['php8.3-inotify']],
            'Interbase'                   => ['packages' => ['php8.3-interbase']],
            'Intl (Internationalisation)' => ['packages' => ['php8.3-intl']],
            'LDAP'                        => ['packages' => ['php8.3-ldap']],
            'LZ4'                         => ['packages' => ['php8.3-lz4']],
            'Mailparse'                   => ['packages' => ['php8.3-mailparse']],
            'MaxMind DB'                  => ['packages' => ['php8.3-maxminddb']],
            'mcrypt'                      => ['packages' => ['php8.3-mcrypt']],
            'Memcache'                    => ['packages' => ['php8.3-memcache']],
            'Memcached'                   => ['packages' => ['php8.3-memcached']],
            'MongoDB'                     => ['packages' => ['php8.3-mongodb']],
            'MessagePack'                 => ['packages' => ['php8.3-msgpack']],
            'MySQL'                       => ['packages' => ['php8.3-mysql']],
            'OAuth'                       => ['packages' => ['php8.3-oauth']],
            'ODBC'                        => ['packages' => ['php8.3-odbc']],
            'OpenTelemetry'               => ['packages' => ['php8.3-opentelemetry']],
            'Pcov'                        => ['packages' => ['php8.3-pcov']],
            'PostgreSQL'                  => ['packages' => ['php8.3-pgsql']],
            'PostgreSQL (libpq)'          => ['packages' => ['php8.3-pq']],
            'Phalcon 5'                   => ['packages' => ['php8.3-phalcon']],
            'Pinba'                       => ['packages' => ['php8.3-pinba']],
            'PHPDBG'                      => ['packages' => ['php8.3-phpdbg']],
            'Protobuf'                    => ['packages' => ['php8.3-protobuf']],
            'ps'                          => ['packages' => ['php8.3-ps']],
            'pspell'                      => ['packages' => ['php8.3-pspell']],
            'PSR'                         => ['packages' => ['php8.3-psr']],
            'raphf'                       => ['packages' => ['php8.3-raphf']],
            'Redis'                       => ['packages' => ['php8.3-redis']],
            'rrd'                         => ['packages' => ['php8.3-rrd']],
            'Samba Client'                => ['packages' => ['php8.3-smbclient']],
            'SNMP'                        => ['packages' => ['php8.3-snmp']],
            'SOAP'                        => ['packages' => ['php8.3-soap']],
            'Solr'                        => ['packages' => ['php8.3-solr']],
            'SQLite3'                     => ['packages' => ['php8.3-sqlite3']],
            'ssh2'                        => ['packages' => ['php8.3-ssh2']],
            'STOMP protocol'              => ['packages' => ['php8.3-stomp']],
            'Swoole'                      => ['packages' => ['php8.3-swoole']],
            'Sybase'                      => ['packages' => ['php8.3-sybase']],
            'Tidy'                        => ['packages' => ['php8.3-tidy']],
            'UOPZ'                        => ['packages' => ['php8.3-uopz']],
            'Upload progress'             => ['packages' => ['php8.3-uploadprogress']],
            'UUID'                        => ['packages' => ['php8.3-uuid']],
            'vips'                        => ['packages' => ['php8.3-vips']],
            'Xdebug'                      => ['packages' => ['php8.3-xdebug']],
            'Xhprof'                      => ['packages' => ['php8.3-xhprof']],
            'XMLRPC'                      => ['packages' => ['php8.3-xmlrpc']],
            'XSL'                         => ['packages' => ['php8.3-xsl']],
            'Yac'                         => ['packages' => ['php8.3-yac']],
            'YAML'                        => ['packages' => ['php8.3-yaml']],
            'ZMQ (ZeroMQ)'                => ['packages' => ['php8.3-zmq']],
            'zstd (Zstandard)'            => ['packages' => ['php8.3-zstd']],
        ];
    }
}

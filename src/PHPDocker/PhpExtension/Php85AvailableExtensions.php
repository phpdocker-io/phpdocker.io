<?php
declare(strict_types=1);
/**
 * Copyright 2026 Luis Alberto Pabón Flores
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

class Php85AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['packages' => ['php8.5-curl']],
            'MBSTRING' => ['packages' => ['php8.5-mbstring']],
            'OPCache'  => ['packages' => ['php8.5-opcache']],
            'Readline' => ['packages' => ['php8.5-readline']],
            'XML'      => ['packages' => ['php8.5-xml']],
            'Zip'      => ['packages' => ['php8.5-zip']],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, array<string, string[]>>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            // 'Decimal'                  => ['packages' => ['php8.5-decimal']],
            // 'GRPC'                     => ['packages' => ['php8.5-grpc']],
            // 'Inotify'                  => ['packages' => ['php8.5-inotify']],
            // 'LZ4'                      => ['packages' => ['php8.5-lz4']],
            // 'Protobuf'                 => ['packages' => ['php8.5-protobuf']],
            // 'Pinba'                    => ['packages' => ['php8.5-pinba']],
            // 'Samba Client'             => ['packages' => ['php8.5-smbclient']],
            // 'Solr'                     => ['packages' => ['php8.5-solr']],
            // 'Swoole'                   => ['packages' => ['php8.5-swoole']],
            // 'vips'                     => ['packages' => ['php8.5-vips']],
            // 'Xhprof'                   => ['packages' => ['php8.5-xhprof']],
            // 'zstd (Zstandard)'         => ['packages' => ['php8.5-zstd']],

            'AMQP'                        => ['packages' => ['php8.5-amqp']],
            'AST'                         => ['packages' => ['php8.5-ast']],
            'Bcmath'                      => ['packages' => ['php8.5-bcmath']],
            'bzip2'                       => ['packages' => ['php8.5-bz2']],
            'CGI'                         => ['packages' => ['php8.5-cgi']],
            'DBA'                         => ['packages' => ['php8.5-dba']],
            'DS (Data Structures)'        => ['packages' => ['php8.5-ds']],
            'Enchant'                     => ['packages' => ['php8.5-enchant']],
            'Excimer'                     => ['packages' => ['php8.5-excimer']],
            'GD'                          => ['packages' => ['php8.5-gd']],
            'Gearman'                     => ['packages' => ['php8.5-gearman']],
            'Gmagick (GraphicsMagick)'    => ['packages' => ['php8.5-gmagick']],
            'GMP'                         => ['packages' => ['php8.5-gmp']],
            'GNUPG'                       => ['packages' => ['php8.5-gnupg']],
            'HTTP'                        => ['packages' => ['php8.5-http']],
            'igbinary'                    => ['packages' => ['php8.5-igbinary']],
            'ImageMagick'                 => ['packages' => ['php8.5-imagick']],
            'IMAP'                        => ['packages' => ['php8.5-imap']],
            'Interbase'                   => ['packages' => ['php8.5-interbase']],
            'Intl (Internationalisation)' => ['packages' => ['php8.5-intl']],
            'LDAP'                        => ['packages' => ['php8.5-ldap']],
            'Libvirt'                     => ['packages' => ['php8.5-libvirt-php']],
            'Mailparse'                   => ['packages' => ['php8.5-mailparse']],
            'MaxMind DB'                  => ['packages' => ['php8.5-maxminddb']],
            'mcrypt'                      => ['packages' => ['php8.5-mcrypt']],
            'Memcache'                    => ['packages' => ['php8.5-memcache']],
            'Memcached'                   => ['packages' => ['php8.5-memcached']],
            'MongoDB'                     => ['packages' => ['php8.5-mongodb']],
            'MessagePack'                 => ['packages' => ['php8.5-msgpack']],
            'MySQL'                       => ['packages' => ['php8.5-mysql']],
            'OAuth'                       => ['packages' => ['php8.5-oauth']],
            'ODBC'                        => ['packages' => ['php8.5-odbc']],
            'OpenTelemetry'               => ['packages' => ['php8.5-opentelemetry']],
            'Pcov'                        => ['packages' => ['php8.5-pcov']],
            'PostgreSQL'                  => ['packages' => ['php8.5-pgsql']],
            'PostgreSQL (libpq)'          => ['packages' => ['php8.5-pq']],
            'Phalcon 5'                   => ['packages' => ['php8.5-phalcon']],
            'PHPDBG'                      => ['packages' => ['php8.5-phpdbg']],
            'ps'                          => ['packages' => ['php8.5-ps']],
            'pspell'                      => ['packages' => ['php8.5-pspell']],
            'PSR'                         => ['packages' => ['php8.5-psr']],
            'raphf'                       => ['packages' => ['php8.5-raphf']],
            'Redis'                       => ['packages' => ['php8.5-redis']],
            'rrd'                         => ['packages' => ['php8.5-rrd']],
            'SNMP'                        => ['packages' => ['php8.5-snmp']],
            'SOAP'                        => ['packages' => ['php8.5-soap']],
            'SQLite3'                     => ['packages' => ['php8.5-sqlite3']],
            'ssh2'                        => ['packages' => ['php8.5-ssh2']],
            'STOMP protocol'              => ['packages' => ['php8.5-stomp']],
            'Sybase'                      => ['packages' => ['php8.5-sybase']],
            'Tidy'                        => ['packages' => ['php8.5-tidy']],
            'UOPZ'                        => ['packages' => ['php8.5-uopz']],
            'Upload progress'             => ['packages' => ['php8.5-uploadprogress']],
            'UUID'                        => ['packages' => ['php8.5-uuid']],
            'Xdebug'                      => ['packages' => ['php8.5-xdebug']],
            'XMLRPC'                      => ['packages' => ['php8.5-xmlrpc']],
            'XSL'                         => ['packages' => ['php8.5-xsl']],
            'Yac'                         => ['packages' => ['php8.5-yac']],
            'YAML'                        => ['packages' => ['php8.5-yaml']],
            'ZMQ (ZeroMQ)'                => ['packages' => ['php8.5-zmq']],
        ];
    }
}

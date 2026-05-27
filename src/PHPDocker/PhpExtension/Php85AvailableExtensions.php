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

final class Php85AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['php8.5-curl'],
            'MBSTRING' => ['php8.5-mbstring'],
            'OPCache'  => ['php8.5-opcache'],
            'Readline' => ['php8.5-readline'],
            'XML'      => ['php8.5-xml'],
            'Zip'      => ['php8.5-zip'],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            // 'Decimal'                  => ['php8.5-decimal'],
            // 'GRPC'                     => ['php8.5-grpc'],
            // 'Inotify'                  => ['php8.5-inotify'],
            // 'LZ4'                      => ['php8.5-lz4'],
            // 'Protobuf'                 => ['php8.5-protobuf'],
            // 'Pinba'                    => ['php8.5-pinba'],
            // 'Samba Client'             => ['php8.5-smbclient'],
            // 'Solr'                     => ['php8.5-solr'],
            // 'Swoole'                   => ['php8.5-swoole'],
            // 'vips'                     => ['php8.5-vips'],
            // 'Xhprof'                   => ['php8.5-xhprof'],
            // 'zstd (Zstandard)'         => ['php8.5-zstd'],

            'AMQP'                        => ['php8.5-amqp'],
            'AST'                         => ['php8.5-ast'],
            'Bcmath'                      => ['php8.5-bcmath'],
            'bzip2'                       => ['php8.5-bz2'],
            'CGI'                         => ['php8.5-cgi'],
            'DBA'                         => ['php8.5-dba'],
            'DS (Data Structures)'        => ['php8.5-ds'],
            'Enchant'                     => ['php8.5-enchant'],
            'Excimer'                     => ['php8.5-excimer'],
            'GD'                          => ['php8.5-gd'],
            'Gearman'                     => ['php8.5-gearman'],
            'Gmagick (GraphicsMagick)'    => ['php8.5-gmagick'],
            'GMP'                         => ['php8.5-gmp'],
            'GNUPG'                       => ['php8.5-gnupg'],
            'HTTP'                        => ['php8.5-http'],
            'igbinary'                    => ['php8.5-igbinary'],
            'ImageMagick'                 => ['php8.5-imagick'],
            'IMAP'                        => ['php8.5-imap'],
            'Interbase'                   => ['php8.5-interbase'],
            'Intl (Internationalisation)' => ['php8.5-intl'],
            'LDAP'                        => ['php8.5-ldap'],
            'Libvirt'                     => ['php8.5-libvirt-php'],
            'Mailparse'                   => ['php8.5-mailparse'],
            'MaxMind DB'                  => ['php8.5-maxminddb'],
            'mcrypt'                      => ['php8.5-mcrypt'],
            'Memcache'                    => ['php8.5-memcache'],
            'Memcached'                   => ['php8.5-memcached'],
            'MongoDB'                     => ['php8.5-mongodb'],
            'MessagePack'                 => ['php8.5-msgpack'],
            'MySQL'                       => ['php8.5-mysql'],
            'OAuth'                       => ['php8.5-oauth'],
            'ODBC'                        => ['php8.5-odbc'],
            'OpenTelemetry'               => ['php8.5-opentelemetry'],
            'Pcov'                        => ['php8.5-pcov'],
            'PostgreSQL'                  => ['php8.5-pgsql'],
            'PostgreSQL (libpq)'          => ['php8.5-pq'],
            'Phalcon 5'                   => ['php8.5-phalcon'],
            'PHPDBG'                      => ['php8.5-phpdbg'],
            'ps'                          => ['php8.5-ps'],
            'pspell'                      => ['php8.5-pspell'],
            'PSR'                         => ['php8.5-psr'],
            'raphf'                       => ['php8.5-raphf'],
            'Redis'                       => ['php8.5-redis'],
            'rrd'                         => ['php8.5-rrd'],
            'SNMP'                        => ['php8.5-snmp'],
            'SOAP'                        => ['php8.5-soap'],
            'SQLite3'                     => ['php8.5-sqlite3'],
            'ssh2'                        => ['php8.5-ssh2'],
            'STOMP protocol'              => ['php8.5-stomp'],
            'Sybase'                      => ['php8.5-sybase'],
            'Tidy'                        => ['php8.5-tidy'],
            'UOPZ'                        => ['php8.5-uopz'],
            'Upload progress'             => ['php8.5-uploadprogress'],
            'UUID'                        => ['php8.5-uuid'],
            'Xdebug'                      => ['php8.5-xdebug'],
            'XMLRPC'                      => ['php8.5-xmlrpc'],
            'XSL'                         => ['php8.5-xsl'],
            'Yac'                         => ['php8.5-yac'],
            'YAML'                        => ['php8.5-yaml'],
            'ZMQ (ZeroMQ)'                => ['php8.5-zmq'],
        ];
    }
}

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

final class Php84AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['php8.4-curl'],
            'MBSTRING' => ['php8.4-mbstring'],
            'OPCache'  => ['php8.4-opcache'],
            'Readline' => ['php8.4-readline'],
            'XML'      => ['php8.4-xml'],
            'Zip'      => ['php8.4-zip'],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            // 'Decimal'                  => ['php8.4-decimal'],
            // 'GRPC'                     => ['php8.4-grpc'],
            // 'Inotify'                  => ['php8.4-inotify'],
            // 'LZ4'                      => ['php8.4-lz4'],
            // 'Protobuf'                 => ['php8.4-protobuf'],
            // 'Pinba'                    => ['php8.4-pinba'],
            // 'Samba Client'             => ['php8.4-smbclient'],
            // 'Solr'                     => ['php8.4-solr'],
            // 'Swoole'                   => ['php8.4-swoole'],
            // 'vips'                     => ['php8.4-vips'],
            // 'Xhprof'                   => ['php8.4-xhprof'],
            // 'zstd (Zstandard)'         => ['php8.4-zstd'],

            'AMQP'                        => ['php8.4-amqp'],
            'AST'                         => ['php8.4-ast'],
            'Bcmath'                      => ['php8.4-bcmath'],
            'bzip2'                       => ['php8.4-bz2'],
            'CGI'                         => ['php8.4-cgi'],
            'DBA'                         => ['php8.4-dba'],
            'DS (Data Structures)'        => ['php8.4-ds'],
            'Enchant'                     => ['php8.4-enchant'],
            'Excimer'                     => ['php8.4-excimer'],
            'GD'                          => ['php8.4-gd'],
            'Gearman'                     => ['php8.4-gearman'],
            'Gmagick (GraphicsMagick)'    => ['php8.4-gmagick'],
            'GMP'                         => ['php8.4-gmp'],
            'GNUPG'                       => ['php8.4-gnupg'],
            'HTTP'                        => ['php8.4-http'],
            'igbinary'                    => ['php8.4-igbinary'],
            'ImageMagick'                 => ['php8.4-imagick'],
            'IMAP'                        => ['php8.4-imap'],
            'Interbase'                   => ['php8.4-interbase'],
            'Intl (Internationalisation)' => ['php8.4-intl'],
            'LDAP'                        => ['php8.4-ldap'],
            'Libvirt'                     => ['php8.4-libvirt-php'],
            'Mailparse'                   => ['php8.4-mailparse'],
            'MaxMind DB'                  => ['php8.4-maxminddb'],
            'mcrypt'                      => ['php8.4-mcrypt'],
            'Memcache'                    => ['php8.4-memcache'],
            'Memcached'                   => ['php8.4-memcached'],
            'MongoDB'                     => ['php8.4-mongodb'],
            'MessagePack'                 => ['php8.4-msgpack'],
            'MySQL'                       => ['php8.4-mysql'],
            'OAuth'                       => ['php8.4-oauth'],
            'ODBC'                        => ['php8.4-odbc'],
            'OpenTelemetry'               => ['php8.4-opentelemetry'],
            'Pcov'                        => ['php8.4-pcov'],
            'PostgreSQL'                  => ['php8.4-pgsql'],
            'PostgreSQL (libpq)'          => ['php8.4-pq'],
            'Phalcon 5'                   => ['php8.4-phalcon'],
            'PHPDBG'                      => ['php8.4-phpdbg'],
            'ps'                          => ['php8.4-ps'],
            'pspell'                      => ['php8.4-pspell'],
            'PSR'                         => ['php8.4-psr'],
            'raphf'                       => ['php8.4-raphf'],
            'Redis'                       => ['php8.4-redis'],
            'rrd'                         => ['php8.4-rrd'],
            'SNMP'                        => ['php8.4-snmp'],
            'SOAP'                        => ['php8.4-soap'],
            'SQLite3'                     => ['php8.4-sqlite3'],
            'ssh2'                        => ['php8.4-ssh2'],
            'STOMP protocol'              => ['php8.4-stomp'],
            'Sybase'                      => ['php8.4-sybase'],
            'Tidy'                        => ['php8.4-tidy'],
            'UOPZ'                        => ['php8.4-uopz'],
            'Upload progress'             => ['php8.4-uploadprogress'],
            'UUID'                        => ['php8.4-uuid'],
            'Xdebug'                      => ['php8.4-xdebug'],
            'XMLRPC'                      => ['php8.4-xmlrpc'],
            'XSL'                         => ['php8.4-xsl'],
            'Yac'                         => ['php8.4-yac'],
            'YAML'                        => ['php8.4-yaml'],
            'ZMQ (ZeroMQ)'                => ['php8.4-zmq'],
        ];
    }
}

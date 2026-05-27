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

final class Php83AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['php8.3-curl'],
            'MBSTRING' => ['php8.3-mbstring'],
            'OPCache'  => ['php8.3-opcache'],
            'Readline' => ['php8.3-readline'],
            'XML'      => ['php8.3-xml'],
            'Zip'      => ['php8.3-zip'],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['php8.3-amqp'],
            'AST'                         => ['php8.3-ast'],
            'Bcmath'                      => ['php8.3-bcmath'],
            'bzip2'                       => ['php8.3-bz2'],
            'CGI'                         => ['php8.3-cgi'],
            'DBA'                         => ['php8.3-dba'],
            'Decimal'                     => ['php8.3-decimal'],
            'DS (Data Structures)'        => ['php8.3-ds'],
            'Enchant'                     => ['php8.3-enchant'],
            'GD'                          => ['php8.3-gd'],
            'Gearman'                     => ['php8.3-gearman'],
            'Gmagick (GraphicsMagick)'    => ['php8.3-gmagick'],
            'GMP'                         => ['php8.3-gmp'],
            'GNUPG'                       => ['php8.3-gnupg'],
            'GRPC'                        => ['php8.3-grpc'],
            'HTTP'                        => ['php8.3-http'],
            'igbinary'                    => ['php8.3-igbinary'],
            'ImageMagick'                 => ['php8.3-imagick'],
            'IMAP'                        => ['php8.3-imap'],
            'Inotify'                     => ['php8.3-inotify'],
            'Interbase'                   => ['php8.3-interbase'],
            'Intl (Internationalisation)' => ['php8.3-intl'],
            'LDAP'                        => ['php8.3-ldap'],
            'LZ4'                         => ['php8.3-lz4'],
            'Mailparse'                   => ['php8.3-mailparse'],
            'MaxMind DB'                  => ['php8.3-maxminddb'],
            'mcrypt'                      => ['php8.3-mcrypt'],
            'Memcache'                    => ['php8.3-memcache'],
            'Memcached'                   => ['php8.3-memcached'],
            'MongoDB'                     => ['php8.3-mongodb'],
            'MessagePack'                 => ['php8.3-msgpack'],
            'MySQL'                       => ['php8.3-mysql'],
            'OAuth'                       => ['php8.3-oauth'],
            'ODBC'                        => ['php8.3-odbc'],
            'OpenTelemetry'               => ['php8.3-opentelemetry'],
            'Pcov'                        => ['php8.3-pcov'],
            'PostgreSQL'                  => ['php8.3-pgsql'],
            'PostgreSQL (libpq)'          => ['php8.3-pq'],
            'Phalcon 5'                   => ['php8.3-phalcon'],
            'Pinba'                       => ['php8.3-pinba'],
            'PHPDBG'                      => ['php8.3-phpdbg'],
            'Protobuf'                    => ['php8.3-protobuf'],
            'ps'                          => ['php8.3-ps'],
            'pspell'                      => ['php8.3-pspell'],
            'PSR'                         => ['php8.3-psr'],
            'raphf'                       => ['php8.3-raphf'],
            'Redis'                       => ['php8.3-redis'],
            'rrd'                         => ['php8.3-rrd'],
            'Samba Client'                => ['php8.3-smbclient'],
            'SNMP'                        => ['php8.3-snmp'],
            'SOAP'                        => ['php8.3-soap'],
            'Solr'                        => ['php8.3-solr'],
            'SQLite3'                     => ['php8.3-sqlite3'],
            'ssh2'                        => ['php8.3-ssh2'],
            'STOMP protocol'              => ['php8.3-stomp'],
            'Swoole'                      => ['php8.3-swoole'],
            'Sybase'                      => ['php8.3-sybase'],
            'Tidy'                        => ['php8.3-tidy'],
            'UOPZ'                        => ['php8.3-uopz'],
            'Upload progress'             => ['php8.3-uploadprogress'],
            'UUID'                        => ['php8.3-uuid'],
            'vips'                        => ['php8.3-vips'],
            'Xdebug'                      => ['php8.3-xdebug'],
            'Xhprof'                      => ['php8.3-xhprof'],
            'XMLRPC'                      => ['php8.3-xmlrpc'],
            'XSL'                         => ['php8.3-xsl'],
            'Yac'                         => ['php8.3-yac'],
            'YAML'                        => ['php8.3-yaml'],
            'ZMQ (ZeroMQ)'                => ['php8.3-zmq'],
            'zstd (Zstandard)'            => ['php8.3-zstd'],
        ];
    }
}

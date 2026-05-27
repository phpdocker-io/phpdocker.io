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

final class Php82AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'cURL'     => ['php8.2-curl'],
            'MBSTRING' => ['php8.2-mbstring'],
            'OPCache'  => ['php8.2-opcache'],
            'Readline' => ['php8.2-readline'],
            'XML'      => ['php8.2-xml'],
            'Zip'      => ['php8.2-zip'],
        ];
    }

    /**
     * @inheritDoc
     * @return array<string, string[]>
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'AMQP'                        => ['php8.2-amqp'],
            'AST'                         => ['php8.2-ast'],
            'Bcmath'                      => ['php8.2-bcmath'],
            'bzip2'                       => ['php8.2-bz2'],
            'CGI'                         => ['php8.2-cgi'],
            'DBA'                         => ['php8.2-dba'],
            'Decimal'                     => ['php8.2-decimal'],
            'DS (Data Structures)'        => ['php8.2-ds'],
            'Enchant'                     => ['php8.2-enchant'],
            'GD'                          => ['php8.2-gd'],
            'Gearman'                     => ['php8.2-gearman'],
            'Gmagick (GraphicsMagick)'    => ['php8.2-gmagick'],
            'GMP'                         => ['php8.2-gmp'],
            'GNUPG'                       => ['php8.2-gnupg'],
            'GRPC'                        => ['php8.2-grpc'],
            'HTTP'                        => ['php8.2-http'],
            'igbinary'                    => ['php8.2-igbinary'],
            'ImageMagick'                 => ['php8.2-imagick'],
            'IMAP'                        => ['php8.2-imap'],
            'Inotify'                     => ['php8.2-inotify'],
            'Interbase'                   => ['php8.2-interbase'],
            'Intl (Internationalisation)' => ['php8.2-intl'],
            'LDAP'                        => ['php8.2-ldap'],
            'LZ4'                         => ['php8.2-lz4'],
            'Mailparse'                   => ['php8.2-mailparse'],
            'MaxMind DB'                  => ['php8.2-maxminddb'],
            'mcrypt'                      => ['php8.2-mcrypt'],
            'Memcache'                    => ['php8.2-memcache'],
            'Memcached'                   => ['php8.2-memcached'],
            'MongoDB'                     => ['php8.2-mongodb'],
            'MessagePack'                 => ['php8.2-msgpack'],
            'MySQL'                       => ['php8.2-mysql'],
            'OAuth'                       => ['php8.2-oauth'],
            'ODBC'                        => ['php8.2-odbc'],
            'OpenTelemetry'               => ['php8.2-opentelemetry'],
            'Pcov'                        => ['php8.2-pcov'],
            'PostgreSQL'                  => ['php8.2-pgsql'],
            'PostgreSQL (libpq)'          => ['php8.2-pq'],
            'Phalcon 5'                   => ['php8.2-phalcon'],
            'Pinba'                       => ['php8.2-pinba'],
            'PHPDBG'                      => ['php8.2-phpdbg'],
            'propro'                      => ['php8.2-propro'],
            'Protobuf'                    => ['php8.2-protobuf'],
            'ps'                          => ['php8.2-ps'],
            'pspell'                      => ['php8.2-pspell'],
            'PSR'                         => ['php8.2-psr'],
            'raphf'                       => ['php8.2-raphf'],
            'Redis'                       => ['php8.2-redis'],
            'rrd'                         => ['php8.2-rrd'],
            'Samba Client'                => ['php8.2-smbclient'],
            'SNMP'                        => ['php8.2-snmp'],
            'SOAP'                        => ['php8.2-soap'],
            'Solr'                        => ['php8.2-solr'],
            'SQLite3'                     => ['php8.2-sqlite3'],
            'ssh2'                        => ['php8.2-ssh2'],
            'STOMP protocol'              => ['php8.2-stomp'],
            'Swoole'                      => ['php8.2-swoole'],
            'Sybase'                      => ['php8.2-sybase'],
            'Tidy'                        => ['php8.2-tidy'],
            'UOPZ'                        => ['php8.2-uopz'],
            'Upload progress'             => ['php8.2-uploadprogress'],
            'UUID'                        => ['php8.2-uuid'],
            'vips'                        => ['php8.2-vips'],
            'Xdebug'                      => ['php8.2-xdebug'],
            'Xhprof'                      => ['php8.2-xhprof'],
            'XMLRPC'                      => ['php8.2-xmlrpc'],
            'XSL'                         => ['php8.2-xsl'],
            'Yac'                         => ['php8.2-yac'],
            'YAML'                        => ['php8.2-yaml'],
            'ZMQ (ZeroMQ)'                => ['php8.2-zmq'],
            'zstd (Zstandard)'            => ['php8.2-zstd'],
        ];
    }
}

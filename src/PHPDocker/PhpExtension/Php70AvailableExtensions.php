<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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
 */

namespace PHPDocker\PhpExtension;

/**
 * Extensions available on PHP 7.0.x.
 *
 * @package PHPDocker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class Php70AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getMandatoryExtensionsMap(): array
    {
        return [
            'APC'      => ['packages' => ['php-apcu']],
            'cURL'     => ['packages' => ['php-curl']],
            'JSON'     => ['packages' => ['php-json']],
            'MBSTRING' => ['packages' => ['php-mbstring']],
            'MCrypt'   => ['packages' => ['php-mcrypt']],
            'OPCache'  => ['packages' => ['php-opcache']],
            'Readline' => ['packages' => ['php-readline']],
            'XML'      => ['packages' => ['php-xml']],
            'Zip'      => ['packages' => ['php-zip']],
        ];
    }

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getOptionalExtensionsMap(): array
    {
        return [
            'Memcached'           => ['packages' => ['php-memcached']],
            'MongoDB'             => ['packages' => ['php-mongodb']],
            'MySQL'               => ['packages' => ['php-mysql']],
            'PostgreSQL'          => ['packages' => ['php-pgsql']],
            'Redis'               => ['packages' => ['php-redis']],
            'SQLite3'             => ['packages' => ['php-sqlite3']],
            'bz2'                 => ['packages' => ['php-bz2']],
            'Enchant'             => ['packages' => ['php-enchant']],
            'GD'                  => ['packages' => ['php-gd']],
            'Geoip'               => ['packages' => ['php-geoip']],
            'GMP'                 => ['packages' => ['php-gmp']],
            'igbinary'            => ['packages' => ['php-igbinary']],
            'ImageMagick'         => ['packages' => ['php-imagick']],
            'IMAP'                => ['packages' => ['php-imap']],
            'Interbase'           => ['packages' => ['php-interbase']],
            'Intl'                => ['packages' => ['php-intl']],
            'LDAP'                => ['packages' => ['php-ldap']],
            'MessagePack/msgpack' => ['packages' => ['php-msgpack']],
            'ODBC'                => ['packages' => ['php-odbc']],
            'PHPDBG'              => ['packages' => ['php-phpdbg']],
            'PSpell'              => ['packages' => ['php-pspell']],
            'Recode'              => ['packages' => ['php-recode']],
            'SNMP'                => ['packages' => ['php-snmp']],
            'SOAP'                => ['packages' => ['php-soap']],
            'SSH2'                => ['packages' => ['php-ssh2']],
            'Sybase'              => ['packages' => ['php-sybase']],
            'Tidy'                => ['packages' => ['php-tidy']],
            'XDebug'              => ['packages' => ['php-xdebug']],
            'XMLRPC-EPI'          => ['packages' => ['php-xmlrpc']],
            'XSL'                 => ['packages' => ['php-xsl']],
        ];
    }
}

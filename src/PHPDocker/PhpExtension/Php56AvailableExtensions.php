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
 * Extensions available on PHP 5.6.x.
 *
 * @package AuronConsultingOSS\Docker\PhpExtension
 * @author  Luis A. Pabon Flores
 */
class Php56AvailableExtensions extends BaseAvailableExtensions
{
    /**
     * Must return an array of all available mandatory extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getMandatoryExtensionsMap() : array
    {
        return [
            'APC'      => ['packages' => ['php5-apcu']],
            'cURL'     => ['packages' => ['php5-curl']],
            'JSON'     => ['packages' => ['php5-json']],
            'MCrypt'   => ['packages' => ['php5-mcrypt']],
            'Readline' => ['packages' => ['php5-readline']],
        ];
    }

    /**
     * Must return an array of all available optional extensions, indexed by display name
     * and containing an array of ['packages' => ['deb-package-1', 'deb-package-2' ...]
     *
     * @return array
     */
    protected function getOptionalExtensionsMap() : array
    {
        return [
            'Memcached'                     => ['packages' => ['php5-memcached']],
            'MongoDB (mongo legacy driver)' => ['packages' => ['php5-mongo']],
            'MySQL'                         => ['packages' => ['php5-mysql']],
            'PostgreSQL'                    => ['packages' => ['php5-pgsql']],
            'Redis'                         => ['packages' => ['php5-redis']],
            'SQLite'                        => ['packages' => ['php5-sqlite']],
            'ADOdb'                         => ['packages' => ['php5-adodb']],
            'Cyrus SASL'                    => ['packages' => ['php5-sasl']],
            'Enchant'                       => ['packages' => ['php5-enchant']],
            'ExactImage'                    => ['packages' => ['php5-exactimage']],
            'GD'                            => ['packages' => ['php5-gd']],
            'gearman'                       => ['packages' => ['php5-gearman']],
            'GEOS'                          => ['packages' => ['php5-geos']],
            'GMP'                           => ['packages' => ['php5-gmp']],
            'GeoIP'                         => ['packages' => ['php5-geoip']],
            'gpgme/gnupg'                   => ['packages' => ['php5-gnupg']],
            'Grassroots DICOM VTK'          => ['packages' => ['php5-vtkgdcm']],
            'Grassroots DICOM'              => ['packages' => ['php5-gdcm']],
            'http_pecl'                     => ['packages' => ['php5-pecl-http']],
            'igbinary'                      => ['packages' => ['php5-igbinary']],
            'IMAP'                          => ['packages' => ['php5-imap']],
            'interbase / firebird'          => ['packages' => ['php5-interbase']],
            'internationalisation'          => ['packages' => ['php5-intl']],
            'ImageMagick'                   => ['packages' => ['php5-imagick']],
            'Kerberos'                      => ['packages' => ['php5-remctl']],
            'LASSO'                         => ['packages' => ['php5-lasso']],
            'LDAP'                          => ['packages' => ['php5-ldap']],
            'libvirt'                       => ['packages' => ['php5-libvirt-php']],
            'MapServer'                     => ['packages' => ['php5-mapscript']],
            'Memcache'                      => ['packages' => ['php5-memcache']],
            'MessagePack'                   => ['packages' => ['php5-msgpack']],
            'OAuth 1.0'                     => ['packages' => ['php5-oauth']],
            'ODBC'                          => ['packages' => ['php5-odbc']],
            'PECL radius'                   => ['packages' => ['php5-radius']],
            'PHPDBG'                        => ['packages' => ['php5-phpdbg']],
            'Pinba'                         => ['packages' => ['php5-pinba']],
            'propro'                        => ['packages' => ['php5-propro']],
            'pspell'                        => ['packages' => ['php5-pspell']],
            'raphf'                         => ['packages' => ['php5-raphf']],
            'rrd tool'                      => ['packages' => ['php5-rrd']],
            'Rrecode'                       => ['packages' => ['php5-recode']],
            'Redland RDF'                   => ['packages' => ['php5-librdf']],
            'ssh2'                          => ['packages' => ['php5-ssh2']],
            'SNMP'                          => ['packages' => ['php5-snmp']],
            'solr'                          => ['packages' => ['php5-solr']],
            'STOMP client'                  => ['packages' => ['php5-stomp']],
            'Subversion (SVN)'              => ['packages' => ['php5-svn']],
            'Sybase / MS SQL Server'        => ['packages' => ['php5-sybase']],
            'tidy'                          => ['packages' => ['php5-tidy']],
            'Tokyo Tyrant'                  => ['packages' => ['php5-tokyo-tyrant']],
            'Twig'                          => ['packages' => ['php5-twig']],
            'Uprofiler'                     => ['packages' => ['php5-uprofiler']],
            'Xdebug'                        => ['packages' => ['php5-xdebug']],
            'Xhprof'                        => ['packages' => ['php5-xhprof']],
            'XML-RPC'                       => ['packages' => ['php5-xmlrpc']],
            'XSL'                           => ['packages' => ['php5-xsl']],
            'ZeroMQ'                        => ['packages' => ['php5-zmq']],
        ];
    }
}

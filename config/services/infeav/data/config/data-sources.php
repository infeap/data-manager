<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

return [
    'factories' => [
        \Infeav\Data\Config\DataSourceManager::class => \Infeav\Data\Config\DataSourceManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\DataSourceManager::class => [
                'types' => [
                    'infeav/data' => \Infeav\Data\Config\DataSource\Infeav\DataSystemFactory::class,
                    'infeav/booking' => \Infeav\Data\Config\DataSource\Infeav\BookingSystemFactory::class,

                    'db/ibm_db2' => \Infeav\Data\Config\DataSource\Db\IbmDb2SourceFactory::class,
                    'db/maria' => \Infeav\Data\Config\DataSource\Db\MariaSourceFactory::class,
                    'db/mysql' => \Infeav\Data\Config\DataSource\Db\MySqlSourceFactory::class,
                    'db/oci8' => \Infeav\Data\Config\DataSource\Db\Oci8SourceFactory::class,
                    'db/pgsql' => \Infeav\Data\Config\DataSource\Db\PgSqlSourceFactory::class,
                    'db/sqlite' => \Infeav\Data\Config\DataSource\Db\SqliteSourceFactory::class,
                    'db/sqlsrv' => \Infeav\Data\Config\DataSource\Db\SqlSrvSourceFactory::class,

                    'fs/directory' => \Infeav\Data\Config\DataSource\Fs\DirectorySource::class,
                    'fs/file' => \Infeav\Data\Config\DataSource\Fs\FileSource::class,

                    'remote/ftp' => \Infeav\Data\Config\DataSource\Remote\FtpSource::class,
                    'remote/sftp' => \Infeav\Data\Config\DataSource\Remote\SftpSource::class,

                    'remote/http' => \Infeav\Data\Config\DataSource\Remote\HttpSource::class,

                    'remote/ldap' => \Infeav\Data\Config\DataSource\Remote\LdapSource::class,

                    'remote/mail' => \Infeav\Data\Config\DataSource\Remote\MailSource::class,

                    'remote/webdav' => \Infeav\Data\Config\DataSource\Remote\WebDavSource::class,

                    'reflection' => \Infeav\Data\Config\DataSource\ReflectionSource::class,
                ],
            ],
        ],
    ],
];

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
        \Infeav\Data\Config\DataSourcesManager::class => \Infeav\Data\Config\DataSourcesManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\DataSourcesManager::class => [
                'types' => [
                    'db/ibm_db2' => \Infeav\Data\Config\DataSource\Db\IbmDb2Source::class,
                    'db/maria' => \Infeav\Data\Config\DataSource\Db\MariaSource::class,
                    'db/mysql' => \Infeav\Data\Config\DataSource\Db\MySqlSource::class,
                    'db/oci8' => \Infeav\Data\Config\DataSource\Db\Oci8Source::class,
                    'db/pgsql' => \Infeav\Data\Config\DataSource\Db\PgSqlSource::class,
                    'db/sqlite' => \Infeav\Data\Config\DataSource\Db\SqliteSource::class,
                    'db/sqlsrv' => \Infeav\Data\Config\DataSource\Db\SqlSrvSource::class,

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

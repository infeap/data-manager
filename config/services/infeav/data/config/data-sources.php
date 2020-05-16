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
                    // 'db/ibm_db2' => '...',
                    // 'db/maria' => '...',
                    // 'db/mysql' => '...',
                    // 'db/oci8' => '...',
                    // 'db/pgsql' => '...',
                    // 'db/sqlite' => '...',
                    // 'db/sqlsrv' => '...',

                    // 'fs/directory' => '...',
                    // 'fs/file' => '...',

                    // 'ftp' => '...',
                    // 'sftp' => '...',

                    // 'http' => '...',

                    // 'ldap' => '...',

                    // 'mail' => '...',

                    // 'webdav' => '...',

                    // 'reflection' => '...',
                ],
            ],
        ],
    ],
];

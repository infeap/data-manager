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
        \Infeav\Data\Config\AccessControl\User\UserDataStoreManager::class => \Infeav\Data\Config\AccessControl\User\UserDataStoreManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\AccessControl\User\UserDataStoreManager::class => [
                'types' => [
                    'plain' => \Infeav\Data\Config\AccessControl\User\UserDataStore\PlainDataStoreFactory::class,
                    'data_source' => \Infeav\Data\Config\AccessControl\User\UserDataStore\SourceDataStoreFactory::class,
                ],
            ],
        ],
    ],
];

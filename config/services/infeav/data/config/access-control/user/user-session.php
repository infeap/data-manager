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
        \Infeav\Data\Config\AccessControl\User\UserSessionManager::class => \Infeav\Data\Config\AccessControl\User\UserSessionManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\AccessControl\User\UserSessionManager::class => [
                'types' => [
                    'anonymous' => \Infeav\Data\Config\AccessControl\User\UserSession\AnonymousSession::class,
                    'plain_token' => \Infeav\Data\Config\AccessControl\User\UserSession\PlainTokenSession::class,
                ],
            ],
        ],
    ],
];

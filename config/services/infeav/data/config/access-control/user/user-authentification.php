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
        \Infeav\Data\Config\AccessControl\User\UserAuthenticationManager::class => \Infeav\Data\Config\AccessControl\User\UserAuthenticationManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\AccessControl\User\UserAuthenticationManager::class => [
                'types' => [
                    'multi_factor' => \Infeav\Data\Config\AccessControl\User\UserAuthentication\MultiFactorAuth::class,
                    'password' => \Infeav\Data\Config\AccessControl\User\UserAuthentication\PasswordAuth::class,
                ],
            ],
        ],
    ],
];

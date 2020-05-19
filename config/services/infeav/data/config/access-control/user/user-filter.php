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
        \Infeav\Data\Config\AccessControl\User\UserFilterManager::class => \Infeav\Data\Config\AccessControl\User\UserFilterManagerFactory::class,
    ],
    'services' => [
        'config' => [
            \Infeav\Data\Config\AccessControl\User\UserFilterManager::class => [
                'types' => [
                    'ip_address' => \Infeav\Data\Config\AccessControl\User\UserFilter\IpAddressFilter::class,
                    'request_header' => \Infeav\Data\Config\AccessControl\User\UserFilter\RequestHeaderFilter::class,
                ],
            ],
        ],
    ],
];

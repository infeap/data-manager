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
    \Mezzio\ConfigProvider::class,
    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    \Mezzio\Twig\ConfigProvider::class,

    'services' => [
        'config' => [
            'mezzio' => [
                'error_handler' => [
                    'template_404' => 'page::error/404',
                    'template_error' => 'page::error/500',
                ],
            ],
        ],
    ],
];

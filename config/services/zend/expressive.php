<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

return [
    \Zend\Expressive\ConfigProvider::class,
    \Zend\Expressive\Helper\ConfigProvider::class,
    \Zend\Expressive\Router\ConfigProvider::class,
    \Zend\Expressive\Router\FastRouteRouter\ConfigProvider::class,
    \Zend\Expressive\Twig\ConfigProvider::class,

    'aliases' => [
        'config' => 'app_config',
    ],

    'services' => [
        'app_config' => [
            'zend-expressive' => [
                'error_handler' => [
                    'template_404' => 'page::error/404',
                    'template_error' => 'page::error/500',
                ],
            ],
        ],
    ],
];

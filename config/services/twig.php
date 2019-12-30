<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): array {

    return [
        'services' => [
            'app_config' => [
                'templates' => [
                    'extension' => 'twig',
                    'paths' => [
                        'page' => $app['dir'] . '/templates/page/',
                    ],
                ],
                'twig' => [
                    'assets_url' => rtrim($app['base_path'], '/') . '/',
                    'cache_dir' => $app['checks']['cache_dir_is_writable'] ? $app['config']['cache_dir'] . '/templates/' : false,
                    'extensions' => [
                        \Infeap\Foundation\Template\Twig\AssetExtension::class,
                    ],
                    'globals' => [
                        'app' => $app,
                    ],
                    'strict_variables' => false,
                ],
            ],
        ],
    ];
};

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
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
                        \Twig\Extra\Intl\IntlExtension::class,
                        \Twig\Extra\String\StringExtension::class,

                        \Infeav\Foundation\Template\Twig\AssetExtension::class,
                        \Infeav\Foundation\Template\Twig\ServerRequestExtension::class,
                        \Infeav\Foundation\Template\Twig\StringExtension::class,
                        \Infeav\Foundation\Template\Twig\TranslationExtension::class,
                        \Infeav\Foundation\Template\Twig\TypeExtension::class,
                    ],
                    'globals' => [
                        'app' => [
                            'dir' => $app['dir'],
                            'base_path' => $app['base_path'],
                            'request_path' => $app['request_path'],
                            'config' => [
                                'debug' => $app['config']['debug'],
                                'develop' => $app['config']['develop'],
                                'dev_server_url' => $app['config']['dev_server_url'],
                                'hash' => $app['config']['hash'],
                            ],
                            'version' => $app['version'],
                            'context' => $app['context'],
                        ],
                    ],
                    'strict_variables' => false,
                ],
            ],
        ],
        'invokables' => [
            \Twig\Extra\Intl\IntlExtension::class => \Twig\Extra\Intl\IntlExtension::class,
            \Twig\Extra\String\StringExtension::class => \Twig\Extra\String\StringExtension::class,
        ],
    ];
};

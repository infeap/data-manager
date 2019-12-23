<?php

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

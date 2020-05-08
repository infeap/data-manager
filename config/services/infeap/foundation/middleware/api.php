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
        \Infeav\Foundation\Middleware\Api\ApiResponseMiddleware::class => \Infeav\Foundation\Middleware\Api\ApiResponseMiddlewareFactory::class,
        \Infeav\Foundation\Middleware\Api\ErrorHandler::class => \Infeav\Foundation\Middleware\Api\ErrorHandlerFactory::class,
    ],
    'invokables' => [
        \Infeav\Foundation\Middleware\Api\ErrorResponseGenerator::class => \Infeav\Foundation\Middleware\Api\ErrorResponseGenerator::class,
    ],
    'delegators' => [
        \Infeav\Foundation\Middleware\Api\ErrorHandler::class => [
            \Infeav\Foundation\Middleware\Error\Logging\ListenerDelegatorFactory::class,
        ],
    ],
];

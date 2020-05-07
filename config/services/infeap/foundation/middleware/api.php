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
    'factories' => [
        \Infeap\Foundation\Middleware\Api\ApiResponseMiddleware::class => \Infeap\Foundation\Middleware\Api\ApiResponseMiddlewareFactory::class,
        \Infeap\Foundation\Middleware\Api\ErrorHandler::class => \Infeap\Foundation\Middleware\Api\ErrorHandlerFactory::class,
    ],
    'invokables' => [
        \Infeap\Foundation\Middleware\Api\ErrorResponseGenerator::class => \Infeap\Foundation\Middleware\Api\ErrorResponseGenerator::class,
    ],
    'delegators' => [
        \Infeap\Foundation\Middleware\Api\ErrorHandler::class => [
            \Infeap\Foundation\Middleware\Error\Logging\ListenerDelegatorFactory::class,
        ],
    ],
];

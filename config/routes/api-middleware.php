<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

return [
    '^/api/' => [
        'before' => [
            \Infeap\Foundation\Middleware\Api\ApiResponseMiddleware::class,
            \Infeap\Foundation\Middleware\Api\ErrorHandler::class,
        ],
        'target' => [
            \Mezzio\Router\Middleware\RouteMiddleware::class,
        ],
        'end' => [
            \Infeap\Foundation\Middleware\Router\TrailingSlashMiddleware::class,

            \Infeap\Foundation\Handler\Api\NotFoundHandler::class,
        ],
    ],
];

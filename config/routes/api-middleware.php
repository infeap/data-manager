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
    '^/api/' => [
        'before' => [
            \Infeav\Foundation\Middleware\Api\ApiResponseMiddleware::class,
            \Infeav\Foundation\Middleware\Api\ErrorHandler::class,
        ],
        'target' => [
            \Mezzio\Router\Middleware\RouteMiddleware::class,
        ],
        'end' => [
            \Infeav\Foundation\Middleware\Router\TrailingSlashMiddleware::class,

            \Infeav\Foundation\Handler\Api\NotFoundHandler::class,
        ],
    ],
];

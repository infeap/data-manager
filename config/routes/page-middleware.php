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
    '^(?!/api/).*' => [
        'before' => [
            \Infeav\Foundation\Middleware\Page\ErrorHandler::class,
            \Infeav\Foundation\Middleware\Page\BasicMessageMiddleware::class,

            \Infeav\Foundation\Middleware\I18n\LanguageParamMiddleware::class,
            \Infeav\Foundation\Middleware\I18n\Redirect\PageLanguageMiddleware::class,
        ],
        'target' => [
            \Mezzio\Router\Middleware\RouteMiddleware::class,
        ],
        'end' => [
            \Infeav\Foundation\Middleware\Router\IndexFilesMiddleware::class,
            \Infeav\Foundation\Middleware\Router\TrailingSlashMiddleware::class,

            \Mezzio\Handler\NotFoundHandler::class,
        ],
    ],
];

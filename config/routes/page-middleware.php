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
    '^(?!/api/).*' => [
        'before' => [
            \Infeap\Foundation\Middleware\Page\ErrorHandler::class,
            \Infeap\Foundation\Middleware\Page\BasicMessageMiddleware::class,

            \Infeap\Foundation\Middleware\I18n\LanguageParamMiddleware::class,
            \Infeap\Foundation\Middleware\I18n\Redirect\PageLanguageMiddleware::class,
        ],
        'target' => [
            \Mezzio\Router\Middleware\RouteMiddleware::class,
        ],
        'end' => [
            \Infeap\Foundation\Middleware\Router\IndexFilesMiddleware::class,
            \Infeap\Foundation\Middleware\Router\TrailingSlashMiddleware::class,

            \Mezzio\Handler\NotFoundHandler::class,
        ],
    ],
];

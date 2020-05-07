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
        \Infeap\Foundation\Middleware\Page\BasicMessageMiddleware::class => \Infeap\Foundation\Middleware\Page\BasicMessageMiddlewareFactory::class,
        \Infeap\Foundation\Middleware\Page\ErrorHandler::class => \Infeap\Foundation\Middleware\Page\ErrorHandlerFactory::class,
        \Infeap\Foundation\Middleware\Page\ErrorResponseGenerator::class => \Infeap\Foundation\Middleware\Page\ErrorResponseGeneratorFactory::class,
    ],
];

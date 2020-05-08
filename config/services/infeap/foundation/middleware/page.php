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
        \Infeav\Foundation\Middleware\Page\BasicMessageMiddleware::class => \Infeav\Foundation\Middleware\Page\BasicMessageMiddlewareFactory::class,
        \Infeav\Foundation\Middleware\Page\ErrorHandler::class => \Infeav\Foundation\Middleware\Page\ErrorHandlerFactory::class,
        \Infeav\Foundation\Middleware\Page\ErrorResponseGenerator::class => \Infeav\Foundation\Middleware\Page\ErrorResponseGeneratorFactory::class,
    ],
];

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
    \Infeav\Foundation\Middleware\Router\BasePathMiddleware::class,
    \Infeav\Foundation\Middleware\Helper\ServerRequestMiddleware::class,
    \Mezzio\Helper\ServerUrlMiddleware::class,

    \Mezzio\Router\Middleware\RouteMiddleware::class,

    \Mezzio\Router\Middleware\ImplicitHeadMiddleware::class,
    \Mezzio\Router\Middleware\ImplicitOptionsMiddleware::class,
    \Mezzio\Router\Middleware\MethodNotAllowedMiddleware::class,

    \Mezzio\Helper\UrlHelperMiddleware::class,
    \Mezzio\Helper\BodyParams\BodyParamsMiddleware::class,

    \Mezzio\Router\Middleware\DispatchMiddleware::class,
];

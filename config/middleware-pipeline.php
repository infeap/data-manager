<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Infeap\Foundation\Handler\Page\NotificationExceptionHandler;
use Infeap\Foundation\Middleware\Router\BasePathMiddleware;
use Infeap\Foundation\Middleware\Router\IndexFilesHandler;
use Infeap\Foundation\Middleware\Router\TrailingSlashHandler;

use Laminas\ServiceManager\ServiceManager;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;

return function (Application $app, ServiceManager $serviceManager) {

    $app->pipe(ErrorHandler::class);
    $app->pipe(NotificationExceptionHandler::class);

    $app->pipe(BasePathMiddleware::class);
    $app->pipe(ServerUrlMiddleware::class);

    $app->pipe(RouteMiddleware::class);

    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);

    $app->pipe(UrlHelperMiddleware::class);
    $app->pipe(BodyParamsMiddleware::class);

    $app->pipe(DispatchMiddleware::class);

    $app->pipe(IndexFilesHandler::class);
    $app->pipe(TrailingSlashHandler::class);

    $app->pipe(NotFoundHandler::class);

};

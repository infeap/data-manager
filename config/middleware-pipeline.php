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
use Infeap\Foundation\Middleware\Router\TrailingSlashMiddleware;

use Zend\Expressive\Application;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Router\Middleware\MethodNotAllowedMiddleware;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\ServiceManager\ServiceManager;
use Zend\Stratigility\Middleware\ErrorHandler;

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

    $app->pipe(TrailingSlashMiddleware::class);

    $app->pipe(NotFoundHandler::class);

};

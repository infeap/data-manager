<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Zend\Expressive\Application;
use Zend\ServiceManager\ServiceManager;

return function (Application $app, ServiceManager $serviceManager) {

    $basePath = $serviceManager->get('app_base_path');
    $basePath = rtrim('/', $basePath);

    $initRoutesConfig = require 'routes-config.php';

    $routesConfig = $initRoutesConfig($app, $serviceManager);

    foreach ($routesConfig as $routeName => $routeConfig) {
        if (! is_array($routeConfig)) {
            continue;
        }

        $routePath = $routeConfig['path'] ?? false;

        if ($routePath) {
            unset($routeConfig['path']);

            if (isset($routeConfig['options'])) {
                $inheritedRouteOptions = $routeConfig['options'];
                unset($routeConfig['options']);
            } else {
                $inheritedRouteOptions = null;
            }

            foreach ($routeConfig as $routeMethod => $routeMiddleware) {
                if ($routeMethod == 'any') {
                    $routeMethods = null;
                } else {
                    $routeMethods = array_map(function ($routeMethod) {
                        return trim($routeMethod);
                    }, explode(',', $routeMethod));
                }

                if (is_array($routeMiddleware) && isset($routeMiddleware['options'])) {
                    $routeOptions = $routeMiddleware['options'];
                    unset($routeMiddleware['options']);
                } else {
                    $routeOptions = $inheritedRouteOptions;
                }

                $route = $app->route($basePath . $routePath, $routeMiddleware, $routeMethods, $routeName);

                if ($routeOptions && is_array($routeOptions)) {
                    $route->setOptions($routeOptions);
                }

                // Only use route name once for multiple methods
                $routeName = null;
            }
        }
    }
};

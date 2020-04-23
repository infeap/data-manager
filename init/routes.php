<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Mezzio\Application;

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app, array $routesConfig, Application $application): void {

    $basePath = $app['base_path'];
    $basePath = rtrim($basePath, '/');

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

                $route = $application->route($basePath . $routePath, $routeMiddleware, $routeMethods, $routeName);

                if ($routeOptions && is_array($routeOptions)) {
                    $route->setOptions($routeOptions);
                }

                // Only use route name once for multiple methods
                $routeName = null;
            }
        }
    }
};

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Mezzio\Application;

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app, array $routesConfig, Application $application): void {

    $basePath = $app['base_path'];
    $basePath = rtrim($basePath, '/');

    $routeMethods = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];

    foreach ($routesConfig as $routeName => $routeConfig) {
        if (! (is_string($routeName) && is_array($routeConfig))) {
            continue;
        }

        $routePath = $routeConfig['path'] ?? null;

        if (! $routePath) {
            continue;
        }

        $routeOptions = $routeConfig['options'] ?? null;

        foreach ($routeMethods as $routeMethod) {
            $routeMethodMiddleware = $routeConfig[$routeMethod] ?? null;

            if ($routeMethodMiddleware && is_array($routeMethodMiddleware)) {
                $routeMethodOptions = $routeMethodMiddleware['options'] ?? null;

                if ($routeMethodOptions) {
                    unset($routeMethodMiddleware['options']);
                } else if ($routeOptions) {
                    $routeMethodOptions = $routeOptions;
                }

                $route = $application->route($basePath . $routePath, $routeMethodMiddleware, [$routeMethod], $routeName);

                if ($routeMethodOptions) {
                    $route->setOptions($routeMethodOptions);
                }

                // Only use route name once for multiple methods
                $routeName = null;
            }
        }
    }
};

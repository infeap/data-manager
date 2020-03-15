<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ServiceManager\ServiceManager;
use Mezzio\Application;

return function (Application $app, ServiceManager $serviceManager) {

    $app = [
        'dir' => $serviceManager->get('app_dir'),
        'config' => $serviceManager->get('app_config'),
        'checks' => $serviceManager->get('app_checks'),
    ];

    $configCacheFile = sprintf('%s/config/routes.php',
        $app['config']['cache_dir']);

    if ($app['checks']['context_config_has_changed']) {
        if (is_file($configCacheFile)) {
            unlink($configCacheFile);
        }

        /*
         * Delete FastRoute cache file as well
         */
        $fastrouteCacheFile = $app['config']['cache_dir'] . '/fastroute.php';

        if (is_file($fastrouteCacheFile)) {
            unlink($fastrouteCacheFile);
        }
    }

    $configProviders = [];

    if (! is_file($configCacheFile)) {
        foreach (new RecursiveIteratorIterator(
             new RecursiveDirectoryIterator($app['dir'] . '/config/routes/',
                 FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

            if (preg_match('~\.php$~', $iteratedFile)) {
                $routes = include $iteratedFile;

                if (is_callable($routes)) {
                    $routes = $routes($app);
                }

                if (is_array($routes)) {
                    $routesArray = [];

                    foreach ($routes as $key => $value) {
                        if (is_numeric($key)) {
                            if (class_exists($value)) {
                                $configProviders[] = $value;
                            }
                        } else {
                            $routesArray[$key] = $value;
                        }
                    }

                    if ($routesArray) {
                        $configProviders[] = new ArrayProvider($routesArray);
                    }
                }
            }
        }
    }

    $configProviders[] = new ArrayProvider([
        'config_cache_enabled' => true,
    ]);

    if (! $app['checks']['cache_dir_is_writable']) {
        $configCacheFile = null;
    }

    $aggregator = new ConfigAggregator($configProviders, $configCacheFile);

    return $aggregator->getMergedConfig();
};

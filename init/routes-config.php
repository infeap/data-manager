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

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): array {

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
        $flattenedIteratedFiles = [];

        foreach (new RecursiveIteratorIterator(
             new RecursiveDirectoryIterator($app['dir'] . '/config/routes/',
                 FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

            if (preg_match('~\.php$~', $iteratedFile)) {
                $flattenedIteratedFiles[] = $iteratedFile;
            }
        }

        /*
         * Sort route config files by directory depth
         */
        usort($flattenedIteratedFiles, function (string $fileA, string $fileB): int {
            $directoryDepthA = substr_count($fileA, DIRECTORY_SEPARATOR);
            $directoryDepthB = substr_count($fileB, DIRECTORY_SEPARATOR);

            if ($directoryDepthA == $directoryDepthB) {
                return strcmp($fileA, $fileB);
            }

            return ($directoryDepthA > $directoryDepthB) ? 1 : -1;
        });

        foreach ($flattenedIteratedFiles as $iteratedFile) {
            $config = include $iteratedFile;

            if (is_callable($config)) {
                $config = $config($app);
            }

            if (is_array($config)) {
                $configArray = [];

                foreach ($config as $key => $value) {
                    if (is_numeric($key)) {
                        if (class_exists($value)) {
                            $configProviders[] = $value;
                        }
                    } else {
                        $configArray[$key] = $value;
                    }
                }

                if ($configArray) {
                    $configProviders[] = new ArrayProvider($configArray);
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

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): array {

    $configCacheFile = sprintf('%s/config/services.php',
        $app['config']['cache_dir']);

    if ($app['checks']['context_config_has_changed']) {
        if (is_file($configCacheFile)) {
            unlink($configCacheFile);
        }
    }

    $configProviders = [];

    if (! is_file($configCacheFile)) {
        foreach (new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($app['dir'] . '/config/services/',
                FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

            if (str_ends_with($iteratedFile, '.php')) {
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
                            $configArray['dependencies'][$key] = $value;
                        }
                    }

                    if ($configArray) {
                        $configProviders[] = new ArrayProvider($configArray);
                    }
                }
            }
        }
    }

    $configProviders[] = new ArrayProvider([
        'dependencies' => [
            'services' => [
                'app_dir' => $app['dir'],
                'app_base_path' => $app['base_path'],
                'app_request_path' => $app['request_path'],
                'app_version' => $app['version'],
                'app_context' => $app['context'],
                'app_config' => array_filter($app['config'],
                    fn($key) => ! in_array($key, ['data_sources', 'access_control']), ARRAY_FILTER_USE_KEY),
            ],
        ],

        'config_cache_enabled' => true,
    ]);

    if (! $app['checks']['cache_dir_is_writable']) {
        $configCacheFile = null;
    }

    $aggregator = new ConfigAggregator($configProviders, $configCacheFile);

    $mergedConfig = $aggregator->getMergedConfig();

    /*
     * Add uncachable fields afterwards
     */
    if (isset($app['config']['data_sources'])) {
        $mergedConfig['dependencies']['services']['app_config']['data_sources'] = $app['config']['data_sources'];
    }

    if (isset($app['config']['access_control'])) {
        $mergedConfig['dependencies']['services']['app_config']['access_control'] = $app['config']['access_control'];
    }

    $mergedConfig['dependencies']['services']['app_checks'] = $app['checks'];

    return $mergedConfig;
};

<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;

return function (array $app): array {

    $configCachePath = sprintf('%s/var/cache/config/version-%s-%s-%s',
        $app['dir'], $app['version']['number'],
        str_replace('/', '-', $app['version']['branch']),
        str_replace('/', '-', $app['context']));

    $configCacheHashFile = sprintf('%s-hash.php',
        $configCachePath);

    $configCacheFile = sprintf('%s.php',
        $configCachePath);

    $appConfigHash = crc32(serialize($app['config']));
    $appConfigHasChanged = true;

    if (is_file($configCacheHashFile) && is_readable($configCacheHashFile)) {
        $configCacheHash = include $configCacheHashFile;

        if ($configCacheHash == $appConfigHash) {
            $appConfigHasChanged = false;
        }
    }

    if ($app['config']['debug'] || $app['config']['develop']) {
        $appConfigHasChanged = true;
    }

    if ($appConfigHasChanged) {
        if (is_file($configCacheFile)) {
            unlink($configCacheFile);
        }
    }

    $configProviders = [];

    if (! is_file($configCacheFile)) {
        foreach (new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($app['dir'] . '/config/services/',
                FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS)) as $iteratedFile) {

            if (preg_match('~\.php$~', $iteratedFile)) {
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
                'app_config' => $app['config'],
                'app_version' => $app['version'],
                'app_context' => $app['context'],
            ],
        ],

        'config_cache_enabled' => true,
    ]);

    $aggregator = new ConfigAggregator($configProviders, $configCacheFile);

    if ($appConfigHasChanged) {
        if ((is_file($configCacheHashFile) && is_writable($configCacheHashFile)) ||
            (! is_file($configCacheHashFile) && is_writable(dirname($configCacheHashFile)))) {

            file_put_contents($configCacheHashFile, "<?php\n\nreturn $appConfigHash;\n");
        }
    }

    return $aggregator->getMergedConfig();
};

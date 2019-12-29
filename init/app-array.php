<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * $app keys:
 *
 * $app['dir'] = Application directory (not public/)
 *
 * $app['base_path']
 * $app['request_path']
 *
 * $app['version'] = Version data from version.json file
 * $app['version']['number']
 * $app['version']['date']
 * $app['version']['branch']
 *
 * $app['context'] = Context set in public/.htaccess or 'default'
 *
 * $app['config'] = Context dependend configuration (merged with config/context/* files)
 * $app['config']['debug']
 * $app['config']['develop']
 *
 * $app['config']['cache_dir']
 * $app['config']['log_dir']
 *
 * $app['config']['hash']
 *
 * $app['checks']
 * $app['checks']['cache_dir_is_writable']
 * $app['checks']['context_config_has_changed']
 */
return (function (): callable {

    $app['dir'] = strtr(dirname(__DIR__), [
        DIRECTORY_SEPARATOR => '/',
    ]);

    $app['base_path'] = dirname($_SERVER['PHP_SELF']);

    if (strlen($app['base_path']) > 1) {
        $app['request_path'] = substr($_SERVER['REQUEST_URI'], strlen($app['base_path']));
    } else {
        $app['request_path'] = $_SERVER['REQUEST_URI'];
    }

    $app['config']['debug'] = true; // during init
    $app['config']['develop'] = false; // during init

    $app['config']['log_dir'] = $app['dir'] . '/var/logs';

    $initPhp = require $app['dir'] . '/init/php.php';
    $initPhp($app);

    $appVersionFile = $app['dir'] . '/version.json';

    if (! (is_file($appVersionFile) && is_readable($appVersionFile))) {
        http_response_code(500);
        exit('The application files are not (yet) setup. Please read the installation documentation. Concretely, the version.json file is missing or not readable.');
    }

    $app['version'] = json_decode(file_get_contents($appVersionFile), true);

    if (! (is_array($app['version']) && isset($app['version']['number']) && isset($app['version']['date']) && isset($app['version']['branch']))) {
        http_response_code(500);
        exit('The application files are corrupted. Concretely, the version.json file is missing the "number", "date" and/or "branch" key.');
    }

    if (! is_file($app['dir'] . '/public/.htaccess')) {
        if (is_writable($app['dir'] . '/public/') && is_readable($app['dir'] . '/public/.htaccess-default')) {
            if (copy($app['dir'] . '/public/.htaccess-default', $app['dir'] . '/public/.htaccess')) {
                header('Refresh: 0');
                exit('Please reload this page.');
            }
        }

        http_response_code(500);
        exit('The application files are not (yet) setup. Please read the installation documentation. Concretely, the public/.htaccess file is missing.');
    }

    $app['context'] = getenv('INFEAP_CONTEXT');

    if (! $app['context']) {
        $app['context'] = 'default';
    }

    $appContextConfigFile = $app['dir'] . '/config/context/' . $app['context'] . '.php';

    if (! is_file($appContextConfigFile)) {
        $appContextExampleConfigFile = $app['dir'] . '/config/context/example-' . $app['context'] . '.php';

        if (is_file($appContextExampleConfigFile) && is_readable($appContextExampleConfigFile) && is_writable(dirname($appContextExampleConfigFile))) {
            copy($appContextExampleConfigFile, $appContextConfigFile);
        }
    }

    if (! (is_file($appContextConfigFile) && is_readable($appContextConfigFile))) {
        http_response_code(500);
        exit('The application files are not (yet) setup. Please read the installation documentation. Concretely, the context configuration file "config/context/' . $app['context'] . '.php" is missing or not readable.');
    }

    $appContextConfig = require $appContextConfigFile;

    if (! $appContextConfig) {
        http_response_code(500);
        exit('The application files are not (yet) setup. Please read the installation documentation. Concretely, the context configuration file "config/context/' . $app['context'] . '.php" does not contain valid code.');
    }

    if (is_callable($appContextConfig)) {
        $appContextConfig = $appContextConfig($app);
    }

    if (! is_array($appContextConfig)) {
        http_response_code(500);
        exit('The application files are not (yet) setup. Please read the installation documentation. Concretely, the context configuration file "config/context/' . $app['context'] . '.php" does not return an array.');
    }

    $cacheDir = $app['dir'] . '/var/cache';

    $app['config']['cache_dir'] = sprintf('%s/version-%s-%s/%s',
        $cacheDir,
        str_replace('/', '-', $app['version']['number']),
        str_replace('/', '-', $app['version']['branch']),
        str_replace('/', '-', $app['context']));

    $app['config'] = array_merge($app['config'], $appContextConfig);

    $initPhp($app);

    $app['checks']['cache_dir_is_writable'] = is_writable($cacheDir);

    if (! is_dir($app['config']['cache_dir']) && $app['checks']['cache_dir_is_writable']) {
        mkdir($app['config']['cache_dir'], 0775, true);
    }

    $app['checks']['cache_dir_is_writable'] = is_writable($app['config']['cache_dir']);

    $configCacheDir = $app['config']['cache_dir'] . '/config';

    if (! is_dir($configCacheDir) && $app['checks']['cache_dir_is_writable']) {
        mkdir($configCacheDir);
    }

    $app['config']['hash'] = crc32(serialize($app['config']));

    $app['checks']['context_config_has_changed'] = true;

    $cachedContextConfigHashFile = $configCacheDir . '/context-hash.php';

    if (is_file($cachedContextConfigHashFile) && is_readable($cachedContextConfigHashFile)) {
        $cachedContextConfigHash = include $cachedContextConfigHashFile;

        if ($cachedContextConfigHash == $app['config']['hash']) {
            $app['checks']['context_config_has_changed'] = false;
        }
    }

    if ($app['config']['debug'] || $app['config']['develop']) {
        $app['checks']['context_config_has_changed'] = true;
    }

    if ($app['checks']['context_config_has_changed']) {
        if ((is_file($cachedContextConfigHashFile) && is_writable($cachedContextConfigHashFile)) ||
            (! is_file($cachedContextConfigHashFile) && is_writable(dirname($cachedContextConfigHashFile)))) {

            file_put_contents($cachedContextConfigHashFile, "<?php\n\nreturn {$app['config']['hash']};\n");
        }
    }

    return function (callable $callback) use ($app) {

        return $callback($app);
    };

})();

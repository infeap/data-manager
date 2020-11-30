<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

/*
 * $app keys:
 *
 * $app['dir'] = Application root directory path (not public/) without trailing slash
 *
 * $app['base_path'] = '' (empty) or with leading and without trailing slash (like '/public')
 * $app['request_path'] = '/' or with leading (and request dependent trailing) slash; without query params
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
 * $app['config']['dev_server_url'] = For Webpack DevServer; always with trailing slash
 *
 * $app['config']['cache_dir'] = Without trailing slash
 * $app['config']['log_dir'] = Without trailing slash
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

    $app['base_path'] = rtrim(dirname($_SERVER['PHP_SELF']), '/');

    if ($app['base_path']) {
        $app['request_path'] = substr($_SERVER['REQUEST_URI'], strlen($app['base_path']));
    } else {
        $app['request_path'] = $_SERVER['REQUEST_URI'];
    }

    $appRequestPathQueryPos = strpos($app['request_path'], '?');

    if ($appRequestPathQueryPos) {
        $app['request_path'] = substr($app['request_path'], 0, $appRequestPathQueryPos);
    }

    $app['config']['debug'] = true; // during init
    $app['config']['develop'] = false; // during init

    $app['config']['log_dir'] = $app['dir'] . '/var/logs';

    $initPhp = require $app['dir'] . '/init/php.php';
    $initPhp($app);

    $appVersionFile = $app['dir'] . '/version.json';

    if (! (is_file($appVersionFile) && is_readable($appVersionFile))) {
        http_response_code(500);
        infeav_render_init_message('Application files required', [
            'The application files are not (yet) setup. Please read the installation documentation.',
            'Concretely, the <code>version.json</code> file is missing or not readable.',
        ]);
    }

    $app['version'] = json_decode(file_get_contents($appVersionFile), true);

    if (! (is_array($app['version']) && isset($app['version']['number']) && isset($app['version']['date']) && isset($app['version']['branch']))) {
        http_response_code(500);
        infeav_render_init_message('Application files corrupted', [
            'The application files are corrupted.',
            'Concretely, the <code>version.json</code> file is missing the <code>"number"</code>, <code>"date"</code> and/or <code>"branch"</code> key.',
        ]);
    }

    if (! is_file($app['dir'] . '/public/.htaccess')) {
        if (is_writable($app['dir'] . '/public/') && is_readable($app['dir'] . '/public/.htaccess-default')) {
            if (copy($app['dir'] . '/public/.htaccess-default', $app['dir'] . '/public/.htaccess')) {
                header('refresh: 0');
                infeav_render_init_message('Reload required', 'Please reload this page.');
            }
        }

        http_response_code(500);
        infeav_render_init_message('Application files required', [
            'The application files are not (yet) setup. Please read the installation documentation.',
            'Concretely, the <code>public/.htaccess</code> file is missing. You can rename <code>public/.htaccess-default</code> to <code>.htaccess</code>',
        ]);
    }

    $app['context'] = getenv('INFEAV_CONTEXT');

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
        infeav_render_init_message('Application files required', [
            'The application files are not (yet) setup. Please read the installation documentation.',
            'Concretely, the context configuration file <code>config/context/' . $app['context'] . '.php</code> is missing or not readable.',
        ]);
    }

    $appContextConfig = require $appContextConfigFile;

    if (! $appContextConfig) {
        http_response_code(500);
        infeav_render_init_message('Application files required', [
            'The application files are not (yet) setup. Please read the installation documentation.',
            'Concretely, the context configuration file <code>config/context/' . $app['context'] . '.php</code> does not return a value.',
        ]);
    }

    if (is_callable($appContextConfig)) {
        $appContextConfig = $appContextConfig($app);
    }

    if (! is_array($appContextConfig)) {
        http_response_code(500);
        infeav_render_init_message('Application files required', [
            'The application files are not (yet) setup. Please read the installation documentation.',
            'Concretely, the context configuration file <code>config/context/' . $app['context'] . '.php</code> does not return a callable or array.',
        ]);
    }

    $app['config']['cache_dir'] = $app['dir'] . '/var/cache';

    $app['config'] = array_merge($app['config'], $appContextConfig);

    $app['config']['cache_dir'] = sprintf('%s/version-%s-%s/%s',
        rtrim($app['config']['cache_dir'], '/'),
        str_replace('/', '-', $app['version']['number']),
        str_replace('/', '-', $app['version']['branch']),
        str_replace('/', '-', $app['context']));

    $app['config']['log_dir'] = rtrim($app['config']['log_dir'], '/');

    if (isset($app['config']['dev_server_url'])) {
        $app['config']['dev_server_url'] = rtrim($app['config']['dev_server_url'], '/') . '/';
    } else if ($app['config']['develop']) {
        $app['config']['dev_server_url'] = 'https://localhost:8080/';
    } else {
        $app['config']['dev_server_url'] = null;
    }

    $initPhp($app);

    if (! is_dir($app['config']['cache_dir']) && is_writable(dirname(dirname($app['config']['cache_dir'])))) {
        mkdir($app['config']['cache_dir'], 0775, true);
    }

    $app['checks']['cache_dir_is_writable'] = is_writable($app['config']['cache_dir']);

    $configCacheDir = $app['config']['cache_dir'] . '/config';

    if (! is_dir($configCacheDir) && $app['checks']['cache_dir_is_writable']) {
        mkdir($configCacheDir, 0775);
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

            file_put_contents($cachedContextConfigHashFile, "<?php\n\nreturn " . $app['config']['hash'] . ";\n");
        }
    }

    return function (callable $callback) use ($app) {

        return $callback($app);
    };

})();

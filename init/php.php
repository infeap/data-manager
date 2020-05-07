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
 * See init/app-array.php for available $app keys
 */
return function (array $app): void {

    if ($app['config']['debug']) {
        ini_set('error_reporting', E_ALL);
    } else {
        ini_set('error_reporting', E_ERROR | E_USER_ERROR | E_WARNING | E_USER_WARNING | E_PARSE);
    }

    ini_set('display_errors', $app['config']['debug'] ? '1' : '0');
    ini_set('log_errors', $app['config']['debug'] ? '0' : '1');

    ini_set('error_log', $app['config']['log_dir'] . '/errors.txt');

    ini_set('ignore_repeated_errors', '1');
    ini_set('html_errors', $app['config']['debug'] ? '1' : '0');

    ini_set('ignore_user_abort', $app['config']['debug'] ? '0' : '1');

    ini_set('default_charset', 'UTF-8');

    $phpConfig = $app['config']['php'] ?? false;

    if ($phpConfig && is_array($phpConfig)) {
        foreach ($phpConfig as $key => $value) {
            ini_set($key, $value);
        }
    }
};

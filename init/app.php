<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

if (! defined('PHP_VERSION_ID') || PHP_VERSION_ID < 70200) {
    if (function_exists('http_response_code')) {
        http_response_code(500);
    }

    exit('PHP 7.2+ is required for this application to work (currently running PHP ' . PHP_VERSION . ')');
}

$initAppArray = require 'app-array.php';

return $initAppArray(function (array $app): callable {

    $autoloadFile = $app['dir'] . '/vendor/autoload.php';

    if (! (is_file($autoloadFile) && is_readable($autoloadFile))) {
        http_response_code(500);
        exit('The application dependencies are not (yet) installed. Please read the installation documentation or use Composer to install.');
    }

    require $autoloadFile;

    return function (callable $callback) use ($app) {

        return $callback($app);
    };

});

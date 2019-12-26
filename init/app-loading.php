<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

$initAppArray = require 'app-array.php';

/*
 * See init/app-array.php for available $app keys
 */
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

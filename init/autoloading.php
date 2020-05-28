<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
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
        infeav_render_init_message('Dependencies required',
            'The application dependencies are not (yet) installed. Please read the installation documentation and use Composer to install.');
    }

    require_once $autoloadFile;

    return function (callable $callback) use ($app) {

        return $callback($app);
    };
});

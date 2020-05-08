<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Laminas\ServiceManager\ServiceManager;

/*
 * See init/app-array.php for available $app keys
 */
return function (array $app): ServiceManager {

    $initServiceConfig = require 'service-config.php';
    $serviceConfig = $initServiceConfig($app);

    $serviceManagerConfig = $serviceConfig['dependencies'];

    return new ServiceManager($serviceManagerConfig);
};

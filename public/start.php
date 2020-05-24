<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

$initApp = require '../init/app.php';

/*
 * See init/app-array.php for available $appBaseConfig keys
 */
$initApp(function ($appBaseConfig) {

    $initServiceManager = require '../init/service-manager.php';

    /** @var \Laminas\ServiceManager\ServiceManager $serviceManager */
    $serviceManager = $initServiceManager($appBaseConfig);

    $initRoutesConfig = require '../init/routes-config.php';
    $routesConfig = $initRoutesConfig($appBaseConfig);

    /** @var \Mezzio\Application $app */
    $app = $serviceManager->get(\Mezzio\Application::class);

    $initMiddlewarePipeline = require '../init/middleware-pipeline.php';
    $initMiddlewarePipeline($appBaseConfig, $routesConfig, $app);

    $initRoutes = require '../init/routes.php';
    $initRoutes($appBaseConfig, $routesConfig, $app);

    $initQuickClasses = require '../init/quick-classes.php';
    $initQuickClasses($serviceManager);

    $app->run();

});

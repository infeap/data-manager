<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

$initApp = require '../init/app.php';

$initApp(function (array $appBaseConfig) {

    $initServiceManager = require '../init/service-manager.php';

    /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
    $serviceManager = $initServiceManager($appBaseConfig);

    /** @var \Zend\Expressive\Application $app */
    $app = $serviceManager->get(\Zend\Expressive\Application::class);

    echo 'Infeap Data Manager is growing';

});

<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\Router;

use Laminas\ServiceManager\ServiceManager;

class BasePathMiddlewareFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new BasePathMiddleware(
            $serviceManager->get('app_base_path'),
            $serviceManager->get('app_request_path'),
        );
    }

}

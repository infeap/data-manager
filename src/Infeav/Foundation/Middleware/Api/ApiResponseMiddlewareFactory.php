<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Api;

use Laminas\ServiceManager\ServiceManager;

class ApiResponseMiddlewareFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new ApiResponseMiddleware(
            $serviceManager->get('app_config')['debug'],
            $serviceManager->get('app_dir'),
        );
    }

}

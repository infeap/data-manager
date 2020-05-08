<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Helper;

use Infeav\Foundation\Http\Request\Helper\ServerRequestHelper;
use Laminas\ServiceManager\ServiceManager;

class ServerRequestMiddlewareFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new ServerRequestMiddleware(
            $serviceManager->get(ServerRequestHelper::class),
        );
    }

}

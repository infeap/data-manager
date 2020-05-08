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
use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Http\Message\ResponseInterface;

class ErrorHandlerFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new ErrorHandler(
            $serviceManager->get(ResponseInterface::class),
            $serviceManager->get(ErrorResponseGenerator::class),
        );
    }

}

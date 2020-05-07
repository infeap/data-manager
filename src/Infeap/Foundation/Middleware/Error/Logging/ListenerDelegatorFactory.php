<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\Error\Logging;

use Laminas\ServiceManager\ServiceManager;
use Laminas\Stratigility\Middleware\ErrorHandler;

class ListenerDelegatorFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, callable $serviceFactory)
    {
        /** @var ErrorHandler $errorHandler */
        $errorHandler = $serviceFactory();

        if (! $serviceManager->get('app_config')['debug']) {

            $loggingListener = $serviceManager->get(Listener::class);

            $errorHandler->attachListener($loggingListener);
        }

        return $errorHandler;
    }

}

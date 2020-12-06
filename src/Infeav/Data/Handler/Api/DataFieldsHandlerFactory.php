<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Handler\Api;

use Infeav\Data\Config\AccessControl;
use Infeav\Data\Config\DataSourceManager;
use Laminas\ServiceManager\ServiceManager;

class DataFieldsHandlerFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new DataFieldsHandler(
            $serviceManager->get(AccessControl::class),
            $serviceManager->get(DataSourceManager::class),
        );
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl;

use Laminas\ServiceManager\ServiceManager;

class PermissionManagerFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $permissionsConfig = [])
    {
        return new PermissionManager(
            $permissionsConfig,
        );
    }

}

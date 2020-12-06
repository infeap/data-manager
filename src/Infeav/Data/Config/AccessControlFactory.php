<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config;

use Infeav\Data\Config\AccessControl\PermissionManager;
use Infeav\Data\Config\AccessControl\RoleManager;
use Infeav\Data\Config\AccessControl\UserProxyManager;
use Laminas\ServiceManager\ServiceManager;

class AccessControlFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        $accessControlConfig = $serviceManager->get('app_config')['access_control'] ?? [];

        if (! is_array($accessControlConfig)) {
            $accessControlConfig = [];
        }

        $permissionsConfig = $accessControlConfig['permissions'] ?? [];
        $rolesConfig = $accessControlConfig['roles'] ?? [];
        $usersConfig = $accessControlConfig['users'] ?? [];

        return new AccessControl(
            $serviceManager->build(PermissionManager::class, $permissionsConfig),
            $serviceManager->build(RoleManager::class, $rolesConfig),
            $serviceManager->build(UserProxyManager::class, $usersConfig),
        );
    }

}

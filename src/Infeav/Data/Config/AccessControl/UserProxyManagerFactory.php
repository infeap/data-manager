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

use Infeav\Data\Config\AccessControl\User\UserAuthenticationManager;
use Infeav\Data\Config\AccessControl\User\UserDataStoreManager;
use Infeav\Data\Config\AccessControl\User\UserFilterManager;
use Infeav\Data\Config\AccessControl\User\UserIdentificationManager;
use Infeav\Data\Config\AccessControl\User\UserSessionManager;
use Laminas\ServiceManager\ServiceManager;

class UserProxyManagerFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $userProxiesConfig = [])
    {
        return new UserProxyManager(
            $userProxiesConfig,
            $serviceManager->get(UserFilterManager::class),
            $serviceManager->get(UserDataStoreManager::class),
            $serviceManager->get(UserIdentificationManager::class),
            $serviceManager->get(UserAuthenticationManager::class),
            $serviceManager->get(UserSessionManager::class),
        );
    }

}

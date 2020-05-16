<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl\User;

use Infeav\Foundation\ServiceManager\PluginManager\TypesConfigTrait;
use Laminas\ServiceManager\ServiceManager;

class UserDataStoreManagerFactory
{
    use TypesConfigTrait;

    public function __invoke(ServiceManager $serviceManager)
    {
        $serviceTypesConfig = $this->getServiceTypesConfig($serviceManager, UserDataStoreManager::class);

        return new UserDataStoreManager(
            $serviceManager,
            $serviceTypesConfig,
        );
    }

}

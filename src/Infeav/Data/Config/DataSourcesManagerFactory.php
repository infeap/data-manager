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

use Infeav\Foundation\ServiceManager\PluginManager\TypesConfigTrait;
use Laminas\ServiceManager\ServiceManager;

class DataSourcesManagerFactory
{
    use TypesConfigTrait;

    public function __invoke(ServiceManager $serviceManager)
    {
        $serviceTypesConfig = $this->getServiceTypesConfig($serviceManager, DataSourcesManager::class);

        return new DataSourcesManager(
            $serviceManager->get('app_config')['data_sources'] ?? [],
            $serviceManager,
            $serviceTypesConfig,
        );
    }

}

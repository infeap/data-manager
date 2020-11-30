<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\ServiceManager\PluginManager;

use Laminas\ServiceManager\ServiceManager;

trait TypesConfigTrait
{

    public function getServiceTypesConfig(ServiceManager $serviceManager, string $pluginManagerName): array
    {
        $serviceTypesConfig = [
            'invokables' => [],
            'factories' => [],
        ];

        $typesConfig = $serviceManager->get('config')[$pluginManagerName]['types'] ?? [];

        foreach ($typesConfig as $type => $typeServiceName) {
            if (str_ends_with($typeServiceName, 'Factory')) {
                $serviceTypesConfig['factories'][$type] = $typeServiceName;
            } else {
                $serviceTypesConfig['invokables'][$type] = $typeServiceName;
            }
        }

        return $serviceTypesConfig;
    }

}

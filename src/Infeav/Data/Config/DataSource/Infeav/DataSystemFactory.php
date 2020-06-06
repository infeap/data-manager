<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource\Infeav;

use Infeav\Data\Config\DataSourcesManager;
use Laminas\ServiceManager\ServiceManager;

class DataSystemFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        $dataSourceId = $dataSourceConfig['data_source'] ?? null;

        if (! $dataSourceId) {
            // ToDo: Throw exception
        }

        /** @var DataSourcesManager $dataSourcesManager */
        $dataSourcesManager = $serviceManager->get(DataSourcesManager::class);

        return new DataSystem(
            $dataSourceId,
            $dataSourcesManager,
        );
    }

}

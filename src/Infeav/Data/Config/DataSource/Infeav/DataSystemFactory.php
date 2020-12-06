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

use Infeav\Data\Config\DataSourceManager;
use Laminas\ServiceManager\ServiceManager;

class DataSystemFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        $dataSourceName = $dataSourceConfig['data_source_name'] ?? null;

        if (! $dataSourceName) {
            // ToDo: Throw exception
        }

        /** @var DataSourceManager $dataSourceManager */
        $dataSourceManager = $serviceManager->get(DataSourceManager::class);

        return new DataSystem(
            $dataSourceName,
            $dataSourceManager,
        );
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource\Db;

use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Metadata\Source\SqlServerMetadata;
use Laminas\ServiceManager\ServiceManager;

class SqlSrvSourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        if (extension_loaded('sqlsrv')) {
            $dbConfig = [
                'driver' => 'sqlsrv',
            ];
        } else {
            $dbConfig = [
                'driver' => 'pdo',
                'platform' => 'Sqlserver',
            ];
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new SqlServerMetadata($dbAdapter);

        return new SqlSrvSource($dbAdapter, $dbMeta);
    }

}

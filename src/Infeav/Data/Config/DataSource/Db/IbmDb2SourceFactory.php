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
use Laminas\Db\Metadata\Source\MysqlMetadata;
use Laminas\ServiceManager\ServiceManager;

class IbmDb2SourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        if (extension_loaded('ibm_db2')) {
            $dbConfig = [
                'driver' => 'ibmdb2',
            ];
        } else {
            $dbConfig = [
                'driver' => 'pdo',
                'platform' => 'IbmDb2',
            ];
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new MysqlMetadata($dbAdapter);

        return new IbmDb2Source($dbAdapter, $dbMeta);
    }

}

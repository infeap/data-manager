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

class MariaSourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        if (extension_loaded('mysqli')) {
            $dbConfig = [
                'driver' => 'mysqli',
            ];
        } else {
            $dbConfig = [
                'driver' => 'pdo',
                'platform' => 'Mysql',
            ];
        }

        foreach (['hostname', 'port', 'dbname', 'username', 'password', 'charset'] as $configKey) {
            if (isset($dataSourceConfig[$configKey])) {
                $dbConfig[$configKey] = $dataSourceConfig[$configKey];
            }
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new MysqlMetadata($dbAdapter);

        return new MariaSource($dbAdapter, $dbMeta);
    }

}

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
use Laminas\Db\Metadata\Source\SqliteMetadata;
use Laminas\ServiceManager\ServiceManager;

class SqliteSourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        $dbConfig = [
            'driver' => 'pdo_sqlite',
            'platform' => 'Sqlite',
        ];

        if (isset($dataSourceConfig['file'])) {
            $dbConfig['database'] = $dataSourceConfig['file'];
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new SqliteMetadata($dbAdapter);

        return new SqliteSource($dbAdapter, $dbMeta);
    }

}

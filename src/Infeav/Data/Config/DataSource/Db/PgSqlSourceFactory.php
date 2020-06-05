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
use Laminas\Db\Metadata\Source\PostgresqlMetadata;
use Laminas\ServiceManager\ServiceManager;

class PgSqlSourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        if (extension_loaded('pgsql')) {
            $dbConfig = [
                'driver' => 'pgsql',
            ];
        } else {
            $dbConfig = [
                'driver' => 'pdo',
                'platform' => 'Postgresql',
            ];
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new PostgresqlMetadata($dbAdapter);

        return new PgSqlSource($dbAdapter, $dbMeta);
    }

}

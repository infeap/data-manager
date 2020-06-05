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
use Laminas\Db\Metadata\Source\OracleMetadata;
use Laminas\ServiceManager\ServiceManager;

class Oci8SourceFactory
{

    public function __invoke(ServiceManager $serviceManager, string $serviceName, array $dataSourceConfig = [])
    {
        if (extension_loaded('oci8')) {
            $dbConfig = [
                'driver' => 'oci8',
            ];
        } else {
            $dbConfig = [
                'driver' => 'pdo',
                'platform' => 'Orcale',
            ];
        }

        $dbAdapter = new DbAdapter($dbConfig);
        $dbMeta = new OracleMetadata($dbAdapter);

        return new Oci8Source($dbAdapter, $dbMeta);
    }

}

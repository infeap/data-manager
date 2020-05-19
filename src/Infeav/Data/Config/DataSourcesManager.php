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

use Infeav\Data\Config\AccessControl\User;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceManager;

class DataSourcesManager extends AbstractPluginManager
{

    protected $instanceOf = DataSource::class;

    protected array $dataSourcesConfig;
    protected AccessControl $accessControl;

    protected ?array $dataSources = null;

    public function __construct(array $dataSourcesConfig, AccessControl $accessControl, ServiceManager $serviceManager, array $serviceTypesConfig)
    {
        $this->dataSourcesConfig = $dataSourcesConfig;
        $this->accessControl = $accessControl;

        parent::__construct($serviceManager, $serviceTypesConfig);
    }

    public function getDataSources(): array
    {
        if ($this->dataSources === null) {
            $this->dataSources = [];

            foreach ($this->dataSourcesConfig as $dataSourceConfig) {
                if (is_array($dataSourceConfig)) {
                    $type = $dataSourceConfig['type'] ?? null;

                    if ($type && $this->has($type)) {
                        $typeConfig = $dataSourceConfig['config'] ?? null;

                        if (! is_array($typeConfig)) {
                            $typeConfig = [];
                        }

                        /** @var DataSource $dataSource */
                        $dataSource = $this->build($type, $typeConfig);

                        unset($dataSourceConfig['config']);
                        $dataSource->setMeta($dataSourceConfig);

                        $this->dataSources[] = $dataSource;
                    }
                }
            }
        }

        return $this->dataSources;
    }

    public function getDataSourcesWithPermission(string $permissionType, User $user): DataSourceList
    {
        $permittedDataSources = [];

        /** @var DataSource $dataSource */
        foreach ($this->getDataSources() as $dataSource) {
            $dataSourceId = $dataSource->getId();

            if ($this->accessControl->hasPermission($user, $permissionType, $dataSourceId)) {
                $permittedDataSources[] = $dataSource;
            }
        }

        return new DataSourceList($permittedDataSources);
    }

}

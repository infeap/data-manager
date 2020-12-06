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

class DataSourceManager extends AbstractPluginManager
{

    protected $instanceOf = DataSource::class;

    protected ?array $dataSources = null;

    public function __construct(
        protected array $dataSourcesConfig,
        protected AccessControl $accessControl,
        ServiceManager $serviceManager,
        array $serviceTypesConfig,
    ) {
        parent::__construct($serviceManager, $serviceTypesConfig);
    }

    public function getAllDataSources(): array
    {
        if ($this->dataSources === null) {
            $this->dataSources = [];

            foreach ($this->dataSourcesConfig as $dataSourceConfig) {
                if (is_array($dataSourceConfig)) {
                    $dataSourceType = $dataSourceConfig['type'] ?? null;

                    if ($dataSourceType && $this->has($dataSourceType)) {
                        $dataSourceTypeConfig = $dataSourceConfig['config'] ?? [];

                        if (! is_array($dataSourceTypeConfig)) {
                            $dataSourceTypeConfig = [];
                        }

                        /** @var DataSource $dataSource */
                        $dataSource = $this->build($dataSourceType, $dataSourceTypeConfig);

                        foreach (['name', 'slug', 'icon', 'label', 'description'] as $configKey) {
                            $configValue = $dataSourceConfig[$configKey] ?? null;

                            if ($configValue && is_string($configValue)) {
                                $dataSourceSetter = 'set' . ucfirst($configKey);

                                if (method_exists($dataSource, $dataSourceSetter)) {
                                    $dataSource->{$dataSourceSetter}($configValue);
                                }
                            }
                        }

                        $annotationsConfig = $dataSourceConfig['annotations'] ?? null;

                        if (is_array($annotationsConfig)) {
                            $annotationsDataSourceName = $annotationsConfig['data_source_name'] ?? null;

                            if (is_string($annotationsDataSourceName)) {
                                $annotationsDataSource = array_filter($this->dataSources,
                                    fn (DataSource $dataSource) => $dataSource->getName() === $annotationsDataSourceName);

                                if (count($annotationsDataSource) === 1) {
                                    $dataSource->setAnnotationsDataSource(current($annotationsDataSource));
                                }
                            }
                        }

                        $this->dataSources[] = $dataSource;
                    }
                }
            }
        }

        return $this->dataSources;
    }

    public function getDataSource(string $name): ?DataSource
    {
        /** @var DataSource $dataSource */
        foreach ($this->getAllDataSources() as $dataSource) {
            if ($dataSource->getName() === $name) {
                return $dataSource;
            }
        }

        return null;
    }

    public function getDataSources(User $forUser, string $withPermissionTo): DataSourceList
    {
        $permittedDataSources = [];

        /** @var DataSource $dataSource */
        foreach ($this->getAllDataSources() as $dataSource) {
            $dataSourceName = $dataSource->getName();

            if ($dataSourceName) {
                if ($this->accessControl->hasPermission($forUser, $withPermissionTo, $dataSourceName)) {
                    $permittedDataSources[] = $dataSource;
                }
            }
        }

        return new DataSourceList($permittedDataSources,
            count($permittedDataSources) == count($this->getAllDataSources()));
    }

}

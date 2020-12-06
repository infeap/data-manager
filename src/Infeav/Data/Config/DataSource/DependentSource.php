<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource;

use Infeav\Data\Config\DataSource;
use Infeav\Data\Config\DataSource\Db\LaminasDbSource;
use Infeav\Data\Config\DataSourceManager;

abstract class DependentSource extends DataSource
{

    protected ?DataSource $dependentDataSource = null;

    public function __construct(
        protected string $dependentDataSourceName,
        protected DataSourceManager $dataSourceManager,
    ) { }

    public function getDependentDataSource(): LaminasDbSource
    {
        if ($this->dependentDataSource === null) {
            $this->dependentDataSource = $this->dataSourceManager->getDataSource($this->dependentDataSourceName);

            if (! $this->dependentDataSource) {
                // ToDo: Throw exception
            }

            if (! ($this->dependentDataSource instanceof LaminasDbSource)) {
                // ToDo: Throw exception
            }
        }

        return $this->dependentDataSource;
    }

}

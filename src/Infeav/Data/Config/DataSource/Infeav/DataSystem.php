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

use Infeav\Data\Config\DataSource;
use Infeav\Data\Config\DataSource\InfeavSource;
use Infeav\Data\Config\DataView\Infeav\Data\CreateView;

class DataSystem extends InfeavSource
{

    public function getIcon(): string
    {
        return $this->getMetaValue('icon', 'collection-fill');
    }

    public function isUsableForAnnotations(): bool
    {
        return true;
    }

    public function getAnnotationsDataSource(): DataSource
    {
        return $this;
    }

    public function assembleSubViews(): array
    {
        $dependentDataSource = $this->getDependentDataSource();

        $dbAdapter = $dependentDataSource->getDbAdapter();
        $dbMeta = $dependentDataSource->getDbMeta();

        return [
            new CreateView($dbAdapter, $dbMeta),
        ];
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Db;

use Infeav\Data\Config\DataView\DbBasedView;

class TablesView extends DbBasedView
{

    public function initMeta(): void
    {
        $this->setMeta([
            'name' => 'tables',
            'icon' => 'files',
            'label' => 'trans:data_views.db.tables.label',
        ]);
    }

    public function assembleChildDataViews(): array
    {
        $childDataViews = [];

        foreach ($this->dbMeta->getTableNames() as $tableName) {
            $childDataViews[] = new TableView($this->dbAdapter, $this->dbMeta, $tableName);
        }

        return $childDataViews;
    }

}

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

use Infeav\Data\Config\DataPartial\SubViewsPartial;
use Infeav\Data\Config\DataView\Db\Tables\CreateView;
use Infeav\Data\Config\DataView\DbBasedView;
use Infeav\Data\Config\DataPartial\SeparatorPartial;
use Infeav\Data\Config\DataViewList;

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

    protected function assemblePartials(): array
    {
        return [
            new SubViewsPartial([
                new CreateView($this->dbAdapter, $this->dbMeta),
            ]),
            new SeparatorPartial(),
            new SubViewsPartial(
                array_map(fn ($tableName) => new TableView($this->dbAdapter, $this->dbMeta, $tableName), $this->dbMeta->getTableNames()),
            ),
        ];
    }

}

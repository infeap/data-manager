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

class TablesView extends DbBasedView
{

    protected ?string $name = 'tables';
    protected ?string $icon = 'files';
    protected ?string $label = 'trans:data_views.db.tables.label';

    protected function assembleDataPartials(): array
    {
        return [
            new SubViewsPartial([
                new CreateView($this->dbAdapter, $this->dbMeta),
            ]),
            new SubViewsPartial(
                array_map(fn ($tableName) => new TableView($this->dbAdapter, $this->dbMeta, $tableName), $this->dbMeta->getTableNames()),
            ),
        ];
    }

}

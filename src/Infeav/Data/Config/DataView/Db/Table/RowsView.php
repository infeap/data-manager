<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Db\Table;

use Infeav\Data\Config\DataView\Db\TableBasedView;

class RowsView extends TableBasedView
{

    public function initMeta(): void
    {
        $this->setMeta([
            'name' => 'rows',
            'icon' => 'list',
            'label' => 'trans:data_views.db.table.rows.label',
        ]);
    }

}

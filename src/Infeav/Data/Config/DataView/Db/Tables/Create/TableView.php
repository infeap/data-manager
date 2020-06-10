<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Db\Tables\Create;

use Infeav\Data\Config\DataView\DbBasedView;

class TableView extends DbBasedView
{

    public function initMeta(): void
    {
        $this->setMeta([
            'name' => 'table',
            'icon' => 'file',
            'label' => 'trans:data_views.db.table.label',
        ]);
    }

}

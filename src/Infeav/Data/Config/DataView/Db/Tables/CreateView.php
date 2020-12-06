<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Db\Tables;

use Infeav\Data\Config\DataView\Db\Tables\Create\TableView;
use Infeav\Data\Config\DataView\DbBasedView;

class CreateView extends DbBasedView
{

    protected ?string $name = 'new';
    protected ?string $icon = 'plus-circle';
    protected ?string $label = 'trans:data_views.new.label';

    public function assembleSubViews(): array
    {
        return [
            new TableView($this->dbAdapter, $this->dbMeta),
        ];
    }

}

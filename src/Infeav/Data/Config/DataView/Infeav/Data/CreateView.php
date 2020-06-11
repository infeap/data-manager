<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView\Infeav\Data;

use Infeav\Data\Config\DataView\DbBasedView;
use Infeav\Data\Config\DataView\Infeav\Data\Create\RecordView;
use Infeav\Data\Config\DataView\Infeav\Data\Create\SchemaView;

class CreateView extends DbBasedView
{

    public function initMeta(): void
    {
        $this->setMeta([
            'name' => 'new',
            'icon' => 'plus-circle',
            'label' => 'trans:data_views.new.label',
        ]);
    }

    public function assembleSubViews(): array
    {
        return [
            new RecordView($this->dbAdapter, $this->dbMeta),
            new SchemaView($this->dbAdapter, $this->dbMeta),
        ];
    }

}
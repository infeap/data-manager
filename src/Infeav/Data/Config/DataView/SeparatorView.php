<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataView;

use Infeav\Data\Config\DataView;

class SeparatorView extends DataView
{

    public function toOverviewArray(): array
    {
        return [
            'type' => 'separator',
        ];
    }

}
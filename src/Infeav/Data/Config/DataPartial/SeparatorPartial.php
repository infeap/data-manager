<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataPartial;

use Infeav\Data\Config\DataPartial;

class SeparatorPartial extends DataPartial
{

    public function getType(): string
    {
        return 'separator';
    }

}

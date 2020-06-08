<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource;

use Infeav\Data\Config\DataSource;

class ReflectionSource extends DataSource
{

    public function getId(): string
    {
        return 'reflection';
    }

    public function getIcon(): string
    {
        return $this->getMetaValue('icon', 'gear-fill');
    }

    public function getLabel(): string
    {
        return 'trans:data_views.reflection.label';
    }

}

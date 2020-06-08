<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\DataSource\Remote;

use Infeav\Data\Config\DataSource\RemoteSource;

class FtpSource extends RemoteSource
{

    public function getIcon(): string
    {
        return $this->getMetaValue('icon', 'folder-symlink');
    }

}

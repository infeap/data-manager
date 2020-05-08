<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Config;

use Infeav\Foundation\Config\AccessControl\User;

class DataSourcesManager
{

    protected $dataSources;

    public function __construct(array $dataSources = [])
    {
        $this->dataSources = $dataSources;
    }

    public function findDataSourcesWithPermission(string $permissionType, ?User $user = null): array
    {
        return [];
    }

}

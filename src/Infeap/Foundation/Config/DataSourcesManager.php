<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Config;

use Infeap\Foundation\Config\AccessControl\User;

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

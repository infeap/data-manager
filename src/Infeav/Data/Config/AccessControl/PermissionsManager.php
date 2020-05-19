<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl;

class PermissionsManager
{

    protected array $permissionsConfig;

    protected ?array $permissions = null;

    public function __construct(array $permissionsConfig)
    {
        $this->permissionsConfig = $permissionsConfig;
    }

    public function getPermissions(): array
    {
        if ($this->permissions === null) {
            $this->permissions = [];

            foreach ($this->permissionsConfig as $permissionConfig) {
                $this->permissions = [...$this->permissions, ...PermissionsFactory::createPermissions($permissionConfig)];
            }
        }

        return $this->permissions;
    }

}

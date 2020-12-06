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

class RoleManager
{

    protected array $roles = [];

    public function __construct(array $rolesConfig = [])
    {
        foreach ($rolesConfig as $roleConfig) {
            if (is_array($roleConfig)) {
                if (Role::isValidConfig($roleConfig)) {
                    $this->roles[] = new Role($roleConfig);
                }
            }
        }
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getRoleNames(): array
    {
        return array_map(fn (Role $role) => $role->getName(), $this->getRoles());
    }

}

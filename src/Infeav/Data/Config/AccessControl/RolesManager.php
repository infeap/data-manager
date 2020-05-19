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

class RolesManager
{

    protected array $rolesConfig;

    protected ?array $roles = null;

    public function __construct(array $rolesConfig)
    {
        $this->rolesConfig = $rolesConfig;
    }

    public function getRoles(): array
    {
        if ($this->roles === null) {
            $this->roles = [];

            foreach ($this->rolesConfig as $roleConfig) {
                if (is_array($roleConfig)) {
                    if (Role::isValidConfig($roleConfig)) {
                        $this->roles[] = new Role($roleConfig);
                    }
                }
            }
        }

        return $this->roles;
    }

    public function getRoleNames(): array
    {
        return array_map(fn(Role $role) => $role->getName(), $this->getRoles());
    }

}

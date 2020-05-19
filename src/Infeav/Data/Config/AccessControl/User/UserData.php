<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl\User;

class UserData
{

    protected array $data;

    protected ?array $roleNames = null;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getRoleNames(): array
    {
        if ($this->roleNames === null) {
            $this->roleNames = [];

            foreach (['roles', 'role'] as $roleDataKey) {
                if (isset($this->data[$roleDataKey])) {
                    if (is_string($this->data[$roleDataKey])) {
                        $this->roleNames[] = $this->data[$roleDataKey];
                    } else if (is_iterable($this->data[$roleDataKey])) {
                        foreach ($this->data[$roleDataKey] as $role) {
                            if (is_string($role)) {
                                $this->roleNames[] = $role;
                            }
                        }
                    }
                }
            }
        }

        return $this->roleNames;
    }

}

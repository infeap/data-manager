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

    protected ?array $roleNames = null;

    public function __construct(
        protected array $data = [],
    ) { }

    public function getRoleNames(): array
    {
        if ($this->roleNames === null) {
            $this->roleNames = [];

            foreach (['roles', 'role'] as $roleKey) {
                if (isset($this->data[$roleKey])) {
                    if (is_string($this->data[$roleKey])) {
                        $this->roleNames[] = $this->data[$roleKey];
                    } else if (is_iterable($this->data[$roleKey])) {
                        foreach ($this->data[$roleKey] as $roleName) {
                            if (is_string($roleName)) {
                                $this->roleNames[] = $roleName;
                            }
                        }
                    }
                }
            }
        }

        return $this->roleNames;
    }

}

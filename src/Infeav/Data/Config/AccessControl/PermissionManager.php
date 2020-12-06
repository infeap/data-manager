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

class PermissionManager
{

    protected array $permissions = [];

    public function __construct(array $permissionsConfig = [])
    {
        $normalizedConfig = [
            'roles' => [],
            'types' => [],
            'data_views' => [],
        ];

        foreach ([
            'roles' => ['roles', 'role'],
            'types' => ['types', 'type'],
            'data_views' => ['data_views', 'data_view', 'data_sources', 'data_source'],
        ] as $key => $keyAliases) {
            foreach ($keyAliases as $keyAlias) {
                foreach ($permissionsConfig as $permissionConfig) {
                    if (isset($permissionConfig[$keyAlias])) {
                        if (is_string($permissionConfig[$keyAlias])) {
                            $normalizedConfig[$key][] = $permissionConfig[$keyAlias];
                        } else if (is_iterable($permissionConfig[$keyAlias])) {
                            foreach ($permissionConfig[$keyAlias] as $dataView) {
                                if (is_string($dataView)) {
                                    $normalizedConfig[$key][] = $dataView;
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($normalizedConfig['roles'] as $role) {
            foreach ($normalizedConfig['types'] as $type) {
                foreach ($normalizedConfig['data_views'] as $dataView) {
                    $permissionConfig = [
                        'role' => $role,
                        'type' => $type,
                        'data_view' => $dataView,
                    ];

                    if (Permission::isValidConfig($permissionConfig)) {
                        $this->permissions[] = new Permission($permissionConfig);
                    }
                }
            }
        }
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

}

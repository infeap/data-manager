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

class PermissionsFactory
{

    public static function createPermissions(array $config): array
    {
        $permissions = [];

        $normalizedConfig = [
            'data_sources' => [],
            'types' => [],
            'roles' => [],
        ];

        foreach ([
            'data_sources' => ['data_sources', 'data_source'],
            'types' => ['types', 'type'],
            'roles' => ['roles', 'role'],
        ] as $key => $keyAliases) {
            foreach ($keyAliases as $keyAlias) {
                if (isset($config[$keyAlias])) {
                    if (is_string($config[$keyAlias])) {
                        $normalizedConfig[$key][] = $config[$keyAlias];
                    } else if (is_iterable($config[$keyAlias])) {
                        foreach ($config[$keyAlias] as $dataSource) {
                            if (is_string($dataSource)) {
                                $normalizedConfig[$key][] = $dataSource;
                            }
                        }
                    }
                }
            }
        }

        foreach ($normalizedConfig['data_sources'] as $dataSource) {
            foreach ($normalizedConfig['types'] as $type) {
                foreach ($normalizedConfig['roles'] as $role) {
                    $permissionConfig = [
                        'data_source' => $dataSource,
                        'type' => $type,
                        'role' => $role,
                    ];

                    if (Permission::isValidConfig($permissionConfig)) {
                        $permissions[] = new Permission($permissionConfig);
                    }
                }
            }
        }

        return $permissions;
    }

}

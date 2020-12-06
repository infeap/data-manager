<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config;

use Infeav\Data\Config\AccessControl\PermissionManager;
use Infeav\Data\Config\AccessControl\RoleManager;
use Infeav\Data\Config\AccessControl\User;
use Infeav\Data\Config\AccessControl\UserProxyManager;
use Psr\Http\Message\ServerRequestInterface;

class AccessControl
{

    public function __construct(
        protected PermissionManager $permissionManager,
        protected RoleManager $roleManager,
        protected UserProxyManager $userProxyManager,
    ) { }

    public function authenticateUser(ServerRequestInterface $request): ?User
    {
        foreach ($this->userProxyManager->getUserProxies() as $userProxy) {
            $userMatch = $userProxy->matchAuthentication($request);

            if ($userMatch) {
                return $userMatch;
            }
        }

        return null;
    }

    public function getSessionUser(ServerRequestInterface $request): User
    {
        foreach ($this->userProxyManager->getUserProxies() as $userProxy) {
            $userMatch = $userProxy->matchSession($request);

            if ($userMatch) {
                return $userMatch;
            }
        }

        return new User();
    }

    public function hasPermission(User $user, string $permissionType, string $dataSourceName): bool
    {
        $validUserRoleNames = array_intersect(
            $user->getData()->getRoleNames(),
            $this->roleManager->getRoleNames(),
        );

        foreach ($this->permissionManager->getPermissions() as $permission) {
            if (in_array($permission->getRoleName(), $validUserRoleNames)) {
                if ($permission->getType() === $permissionType) {
                    if ($permission->getDataSourceName() === $dataSourceName) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

}

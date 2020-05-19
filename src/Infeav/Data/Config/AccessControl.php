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

use Infeav\Data\Config\AccessControl\Permission;
use Infeav\Data\Config\AccessControl\PermissionsManager;
use Infeav\Data\Config\AccessControl\RolesManager;
use Infeav\Data\Config\AccessControl\User;
use Infeav\Data\Config\AccessControl\UserProxy;
use Infeav\Data\Config\AccessControl\UserProxyManager;
use Psr\Http\Message\ServerRequestInterface;

class AccessControl
{

    protected PermissionsManager $permissionsManager;
    protected RolesManager $rolesManager;
    protected UserProxyManager $userProxyManager;

    public function __construct(PermissionsManager $permissionsManager, RolesManager $rolesManager, UserProxyManager $userProxyManager)
    {
        $this->permissionsManager = $permissionsManager;
        $this->rolesManager = $rolesManager;
        $this->userProxyManager = $userProxyManager;
    }

    public function authenticateUser(ServerRequestInterface $request): ?User
    {
        /** @var UserProxy $userProxy */
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
        /** @var UserProxy $userProxy */
        foreach ($this->userProxyManager->getUserProxies() as $userProxy) {
            $userMatch = $userProxy->matchSession($request);

            if ($userMatch) {
                return $userMatch;
            }
        }

        return new User();
    }

    public function hasPermission(User $user, string $permissionType, string $dataSourceId): bool
    {
        $validUserRoleNames = array_intersect($user->getData()->getRoleNames(), $this->rolesManager->getRoleNames());

        /** @var Permission $permission */
        foreach ($this->permissionsManager->getPermissions() as $permission) {
            if ($permission->getDataSource() === $dataSourceId) {
                if ($permission->getType() === $permissionType) {
                    if (in_array($permission->getRole(), $validUserRoleNames)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

}

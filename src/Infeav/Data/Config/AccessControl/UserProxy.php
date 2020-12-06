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

use Infeav\Data\Config\AccessControl\User\UserAuthentication;
use Infeav\Data\Config\AccessControl\User\UserDataStore;
use Infeav\Data\Config\AccessControl\User\UserFilter;
use Infeav\Data\Config\AccessControl\User\UserIdentification;
use Infeav\Data\Config\AccessControl\User\UserSession;
use Psr\Http\Message\ServerRequestInterface;

class UserProxy
{

    public function __construct(
        protected array $filters = [],
        protected ?UserDataStore $dataStore = null,
        protected ?UserIdentification $identification = null,
        protected ?UserAuthentication $authentication = null,
        protected ?UserSession $session = null,
    ) { }

    public function matchAuthentication(ServerRequestInterface $request): ?User
    {
        if (! ($this->dataStore && $this->identification && $this->authentication)) {
            return null;
        }

        foreach ($this->filters as $filter) {
            if ($filter instanceof UserFilter && ! $filter->match($request)) {
                return null;
            }
        }

        $identity = $this->identification->match($request);

        if (! $identity) {
            return null;
        }

        $userData = $this->identification->getUserData($identity, $this->dataStore);

        if (! $userData) {
            return null;
        }

        $isAuthenticated = $this->authentication->authenticate($identity, $userData, $request);

        if (! $isAuthenticated) {
            return null;
        }

        return new User($identity, $userData, $isAuthenticated);
    }

    public function matchSession(ServerRequestInterface $request): ?User
    {
        if (! ($this->dataStore && $this->identification && $this->session)) {
            return null;
        }

        foreach ($this->filters as $filter) {
            if ($filter instanceof UserFilter &&  ! $filter->match($request)) {
                return null;
            }
        }

        $identity = $this->session->match($request, $this->identification);

        if (! $identity) {
            return null;
        }

        $userData = $this->identification->getUserData($identity, $this->dataStore);

        if (! $userData) {
            return null;
        }

        if ($identity instanceof UserIdentification\AnonymousIdentity) {
            return new User(data: $userData, isAuthenticated: false);
        } else {
            return new User($identity, $userData, isAuthenticated: true);
        }
    }

}

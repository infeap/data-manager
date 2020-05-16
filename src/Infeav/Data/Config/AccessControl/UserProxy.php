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
use Infeav\Data\Config\AccessControl\User\UserData;
use Infeav\Data\Config\AccessControl\User\UserDataStore;
use Infeav\Data\Config\AccessControl\User\UserFilter;
use Infeav\Data\Config\AccessControl\User\UserIdentification;
use Infeav\Data\Config\AccessControl\User\UserSession;
use Psr\Http\Message\ServerRequestInterface;

class UserProxy
{

    protected array $filters;
    protected ?UserData $dataStore;
    protected UserIdentification $identification;
    protected UserAuthentication $authentication;
    protected ?UserSession $session;

    public function __construct(
        array $filters,
        ?UserDataStore $dataStore,
        UserIdentification $identification,
        UserAuthentication $authentication,
        ?UserSession $session)
    {
        $this->filters = $filters;
        $this->dataStore = $dataStore;
        $this->identification = $identification;
        $this->authentication = $authentication;
        $this->session = $session;
    }

    public function matchAuthentication(ServerRequestInterface $request): ?User
    {
        /** @var UserFilter $filter */
        foreach ($this->filters as $filter) {
            if (! $filter->match($request)) {
                return null;
            }
        }

        $identity = $this->identification->matchIdentity($request);

        if (! $identity) {
            return null;
        }

        $userData = $this->identification->getUserData($identity, $this->dataStore);

        if (! $userData) {
            return null;
        }

        $isAuthenticated = $this->authentication->authenticate($identity, $request);

        if (! $isAuthenticated) {
            return null;
        }

        return new User($identity, $userData, $isAuthenticated);
    }

    public function matchSession(ServerRequestInterface $request): ?User
    {
        /** @var UserFilter $filter */
        foreach ($this->filters as $filter) {
            if (! $filter->match($request)) {
                return null;
            }
        }

        $identity = $this->session->matchIdentity($this->identification, $request);

        if (! $identity) {
            return null;
        }

        $userData = $this->identification->getUserData($identity, $this->dataStore);

        if (! $userData) {
            return null;
        }

        return new User($identity, $userData, true);
    }

}

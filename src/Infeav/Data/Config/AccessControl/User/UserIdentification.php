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

use Psr\Http\Message\ServerRequestInterface;

abstract class UserIdentification
{

    abstract public function matchIdentity(ServerRequestInterface $request): ?UserIdentity;

    abstract public function getUserData(UserIdentity $identity, UserDataStore $dataStore): ?UserData;

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl\User\UserAuthentication;

use Infeav\Data\Config\AccessControl\User\UserAuthentication;
use Infeav\Data\Config\AccessControl\User\UserIdentity;
use Psr\Http\Message\ServerRequestInterface;

class PasswordAuth extends UserAuthentication
{

    public function authenticate(UserIdentity $identity, ServerRequestInterface $request): bool
    {
        return false; // ToDo
    }

}

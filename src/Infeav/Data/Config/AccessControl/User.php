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

use Infeav\Data\Config\AccessControl\User\UserData;
use Infeav\Data\Config\AccessControl\User\UserIdentity;

class User
{

    protected ?UserIdentity $identity;
    protected ?UserData $data;
    protected bool $isAuthenticated;

    public function __construct(?UserIdentity $identity = null, ?UserData $data = null, bool $isAuthenticated = false)
    {
        $this->identity = $identity;
        $this->data = $data;
        $this->isAuthenticated = $identity && $isAuthenticated;
    }

    public function isIdentified(): bool
    {
        return (bool) $this->identity;
    }

    public function getIdentity(): ?UserIdentity
    {
        return $this->identity;
    }

    public function getData(): ?UserData
    {
        return $this->data;
    }

    public function isAuthenticated(): bool
    {
        return $this->isIdentified() && $this->isAuthenticated;
    }

}

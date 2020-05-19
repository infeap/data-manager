<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config\AccessControl\User\UserIdentification;

use Infeav\Data\Config\AccessControl\User\UserIdentity;

class AnonymousIdentity extends UserIdentity
{

    public function getKey(): string
    {
        throw new \BadMethodCallException('Anonymous Identity has (obviously) no key');
    }

    public function getValue(): string
    {
        throw new \BadMethodCallException('Anonymous Identity has (obviously) no value');
    }

}

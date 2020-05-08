<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Config;

use Infeav\Foundation\Config\AccessControl\User;
use Psr\Http\Message\ServerRequestInterface;

class AccessControl
{

    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function findUserMatch(ServerRequestInterface $request): ?User
    {
        return null;
    }

}

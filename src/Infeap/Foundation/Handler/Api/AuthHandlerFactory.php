<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Handler\Api;

use Laminas\ServiceManager\ServiceManager;

class AuthHandlerFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new AuthHandler();
    }

}
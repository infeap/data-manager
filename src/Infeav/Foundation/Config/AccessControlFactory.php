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

use Laminas\ServiceManager\ServiceManager;

class AccessControlFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new AccessControl(
            $serviceManager->get('app_config')['access_control'] ?? [],
        );
    }

}

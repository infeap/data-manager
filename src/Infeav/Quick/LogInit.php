<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace {
    require 'Log.php';
}

namespace Infeav\Quick {

    use Infeav\Foundation\Log\LogManager;
    use Laminas\ServiceManager\ServiceManager;

    class LogInit
    {

        public static function init(ServiceManager $serviceManager)
        {
            \InfeavQuickLog::setLogManager($serviceManager->get(LogManager::class));
        }

    }
}

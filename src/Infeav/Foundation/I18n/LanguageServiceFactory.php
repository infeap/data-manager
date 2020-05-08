<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\I18n;

use Laminas\ServiceManager\ServiceManager;

class LanguageServiceFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new LanguageService(
            $serviceManager->get('app_config')['supported_languages'],
            $serviceManager->get('app_config')['fallback_language'],
        );
    }

}

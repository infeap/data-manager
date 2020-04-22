<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\I18n;

use Laminas\ServiceManager\ServiceManager;

class LanguageServiceFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new LanguageService(
            $serviceManager->get('app_config')['supported_languages'],
            $serviceManager->get('app_config')['default_language'],
        );
    }

}

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

use Infeav\Foundation\Log\LogManager;
use Laminas\ServiceManager\ServiceManager;

class TranslatorFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        if (! $serviceManager->get('app_config')['debug']) {
            $logManager = $serviceManager->get(LogManager::class);
        } else {
            $logManager = null;
        }

        return new Translator(
            $serviceManager->get(LanguageService::class),
            $serviceManager->get('app_config'),
            $logManager,
        );
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Template\Twig;

use Infeav\Foundation\I18n\LanguageService;
use Infeav\Foundation\I18n\Translator;
use Laminas\ServiceManager\ServiceManager;

class TranslationExtensionFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new TranslationExtension(
            $serviceManager->get(Translator::class),
            $serviceManager->get(LanguageService::class),
        );
    }

}

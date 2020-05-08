<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\I18n\Redirect;

use Infeav\Foundation\I18n\LanguageService;
use Laminas\ServiceManager\ServiceManager;

class PageLanguageMiddlewareFactory
{

    public function __invoke(ServiceManager $serviceManager)
    {
        return new PageLanguageMiddleware(
            $serviceManager->get(LanguageService::class),
        );
    }

}

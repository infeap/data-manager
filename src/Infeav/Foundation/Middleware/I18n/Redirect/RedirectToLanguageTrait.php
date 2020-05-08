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

use Infeav\Foundation\Http\Message\Request\AcceptLanguageTrait;
use Infeav\Foundation\Http\Message\UriToolsTrait;
use Infeav\Foundation\I18n\LanguageService;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

trait RedirectToLanguageTrait
{
    use AcceptLanguageTrait, UriToolsTrait;

    protected function redirectToLanguage(ServerRequestInterface $request, LanguageService $languageService): ?RedirectResponse
    {
        $currentLanguage = $request->getAttribute('language');

        if (! $currentLanguage) {
            $currentLanguage = $languageService->getCurrentLanguage();
        }

        if (! $currentLanguage) {
            $asLanguage = $this->getAcceptedAndSupportedLanguage($request, $languageService->getSupportedLanguages());

            if ($asLanguage) {
                $redirectLanguage = $asLanguage->getPrimaryTag();
            } else {
                $redirectLanguage = $languageService->getFallbackLanguage();
            }

            if (! extension_loaded('intl')) {
                $redirectLanguage = 'en'; // Polyfilled
            }

            return new RedirectResponse($this->getUriWithAdditionalQueryParams($request, ['lang' => $redirectLanguage]), 302);
        }

        return null;
    }

}

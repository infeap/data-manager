<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\I18n\Redirect;

use Infeap\Foundation\Http\Message\AcceptLanguageTrait;
use Infeap\Foundation\Http\Message\UriToolsTrait;
use Infeap\Foundation\I18n\LanguageService;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

trait RedirectToLanguageTrait
{
    use AcceptLanguageTrait, UriToolsTrait;

    protected function redirectToLanguage(ServerRequestInterface $request, LanguageService $languageService): ?RedirectResponse
    {
        if (! $request->getAttribute('language')) {
            $asLanguage = $this->getAcceptedAndSupportedLanguage($request, $languageService->getSupportedLanguages());

            if ($asLanguage) {
                $redirectLanguage = $asLanguage->getPrimaryTag();
            } else {
                $redirectLanguage = $languageService->getDefaultLanguage();
            }

            return new RedirectResponse($this->getUriWithAdditionalQueryParams($request, ['lang' => $redirectLanguage]), 302);
        }

        return null;
    }

}

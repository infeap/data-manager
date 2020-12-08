<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\I18n;

use Infeav\Foundation\Http\Message\Request\AcceptLanguageTrait;
use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Message\UriToolsTrait;
use Infeav\Foundation\Http\Response\BasicMessageResponse;
use Infeav\Foundation\I18n\LanguageService;
use Infeav\Foundation\I18n\Translator;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageMiddleware implements MiddlewareInterface
{
    use AcceptLanguageTrait, UriToolsTrait;

    public function __construct(
        protected LanguageService $languageService,
        protected Translator $translator,
    ) { }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $supportedLanguages = $this->languageService->getSupportedLanguages();

        if ($supportedLanguages) {
            if (count($supportedLanguages) > 1) {
                $languageParam = $request->getQueryParams()['lang'] ?? null;

                if ($languageParam && $this->languageService->isSupportedLanguage($languageParam)) {
                    $this->languageService->updateCurrentLanguage($languageParam);
                    $this->translator->syncCurrentLanguage();
                } else {
                    $acceptLanguageHeader = $this->getAcceptLanguageHeader($request);

                    if ($acceptLanguageHeader) {
                        $matchedLanguageHeader = $acceptLanguageHeader->match(implode(',', $supportedLanguages));

                        if ($matchedLanguageHeader) {
                            $redirectToLanguage = $matchedLanguageHeader->getPrimaryTag();
                        }
                    }

                    if (! (isset($redirectToLanguage) && $redirectToLanguage)) {
                        $fallbackLanguage = $this->languageService->getFallbackLanguage();

                        if ($fallbackLanguage && $this->languageService->isSupportedLanguage($fallbackLanguage)) {
                            $redirectToLanguage = $fallbackLanguage;
                        } else {
                            $redirectToLanguage = current($supportedLanguages);
                        }
                    }

                    return new RedirectResponse(
                        $this->getUriWithAdditionalQueryParams($request, ['lang' => $redirectToLanguage]), StatusCode::FOUND);
                }
            } else {
                $this->languageService->updateCurrentLanguage(current($supportedLanguages));
                $this->translator->syncCurrentLanguage();
            }
        }

        if ($this->languageService->getCurrentLanguage() != 'en' && ! extension_loaded('intl')) {
            return new BasicMessageResponse([
                'type' => 'warning',
                'status' => StatusCode::NOT_IMPLEMENTED,
                'heading' => $this->translator->translate('message.intl.heading'),
                'description' => $this->translator->translateList('message.intl.description'),
            ]);
        }

        return $handler->handle($request);
    }

}

<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\I18n;

use Infeap\Foundation\Http\Message\Response\StatusCode;
use Infeap\Foundation\Http\Response\BasicMessageResponse;
use Infeap\Foundation\I18n\LanguageService;
use Infeap\Foundation\I18n\Translator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageParamMiddleware implements MiddlewareInterface
{

    protected $languageService;
    protected $translator;

    public function __construct(LanguageService $languageService, Translator $translator)
    {
        $this->languageService = $languageService;
        $this->translator = $translator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $languageParam = $request->getQueryParams()['lang'] ?? null;

        if ($languageParam && $this->languageService->isSupportedLanguage($languageParam)) {
            $this->languageService->setCurrentLanguage($languageParam);

            $request = $request->withAttribute('language',
                $this->languageService->normalizeLanguageTag($languageParam));
        }

        if (! extension_loaded('intl')) {
            $messageResponse = new BasicMessageResponse([
                'type' => 'warning',
                'status' => StatusCode::NOT_IMPLEMENTED,
                'heading' => $this->translator->translate('message.intl.heading'),
                'description' => $this->translator->translateList('message.intl.description'),
            ]);

            if ($this->languageService->getCurrentLanguage()) {
                if ($this->languageService->getCurrentLanguage() != 'en') {
                    return $messageResponse;
                }
            } else if ($this->languageService->getFallbackLanguage() != 'en') {
                return $messageResponse;
            }
        }

        return $handler->handle($request);
    }

}

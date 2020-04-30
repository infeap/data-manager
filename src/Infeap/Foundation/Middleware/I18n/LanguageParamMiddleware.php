<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\I18n;

use Infeap\Foundation\Handler\Page\MessageException;
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
            $messageHeading = $this->translator->translate('message.intl.heading');
            $messageDescription = $this->translator->translateList('message.intl.description');

            if ($this->languageService->getCurrentLanguage()) {
                if ($this->languageService->getCurrentLanguage() != 'en') {
                    throw new MessageException($messageHeading, $messageDescription, 'warning');
                }
            } else if ($this->languageService->getFallbackLanguage() != 'en') {
                throw new MessageException($messageHeading, $messageDescription, 'warning');
            }
        }

        return $handler->handle($request);
    }

}

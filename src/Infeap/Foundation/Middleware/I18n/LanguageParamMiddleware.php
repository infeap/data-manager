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

use Infeap\Foundation\I18n\LanguageService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageParamMiddleware implements MiddlewareInterface
{

    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $languageParam = $request->getQueryParams()['lang'] ?? null;

        if ($languageParam && $this->languageService->isSupportedLanguage($languageParam)) {
            $request = $request->withAttribute('language',
                $this->languageService->normalizeLanguageTag($languageParam));
        }

        return $handler->handle($request);
    }

}

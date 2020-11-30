<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Handler\Api;

use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Response\ApiResponse;
use Infeav\Foundation\I18n\LanguageService;
use Infeav\Foundation\I18n\Translator;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TranslationsHandler implements RequestHandlerInterface
{

    public function __construct(
        protected Translator $translator,
        protected LanguageService $languageService,
    ) { }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $textDomain = $request->getAttribute('text-domain');

        if (! $this->translator->hasTextDomain($textDomain)) {
            return new ApiResponse([
                'status' => StatusCode::NOT_FOUND,
                'key' => 'error.translations.text_domain.not_found',
                'details' => [
                    'message' => 'The requested text domain has not been found',
                ],
            ]);
        }

        $languageTag = $request->getAttribute('language-tag');

        if (! str_starts_with($textDomain, 'js-')) {
            return new ApiResponse([
                'status' => StatusCode::FORBIDDEN,
                'key' => 'error.translations.text_domain.forbidden',
                'details' => [
                    'message' => 'The requested text domain is not public, only "js-*" are',
                ],
            ]);
        }

        $messages = $this->translator->getAllMessages($textDomain, $languageTag);

        return new JsonResponse($messages);
    }

}

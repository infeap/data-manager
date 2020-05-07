<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Handler\Api;

use Infeap\Foundation\Http\Message\Response\StatusCode;
use Infeap\Foundation\Http\Response\ApiResponse;
use Infeap\Foundation\I18n\LanguageService;
use Infeap\Foundation\I18n\Translator;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TranslationsHandler implements RequestHandlerInterface
{

    protected $translator;
    protected $languageService;

    public function __construct(Translator $translator, LanguageService $languageService)
    {
        $this->translator = $translator;
        $this->languageService = $languageService;
    }

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

        if (strpos($textDomain, 'js-') !== 0) {
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

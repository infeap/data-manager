<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Http\Message\Request;

use Laminas\Http\Header\Accept\FieldValuePart\LanguageFieldValuePart;
use Laminas\Http\Header\AcceptLanguage;
use Psr\Http\Message\ServerRequestInterface;

trait AcceptLanguageTrait
{

    protected function getAcceptLanguageHeader(ServerRequestInterface $request): ?AcceptLanguage
    {
        $headerLine = $request->getHeaderLine('Accept-Language');

        if (! $headerLine) {
            return null;
        }

        return AcceptLanguage::fromString($headerLine);
    }

    protected function getAcceptedLanguages(ServerRequestInterface $request): array
    {
        $header = $this->getAcceptLanguageHeader($request);

        if (! $header) {
            return [];
        }

        return $header->getPrioritized();
    }

    protected function getAcceptedAndSupportedLanguage(ServerRequestInterface $request, array $supportedLanguages): ?LanguageFieldValuePart
    {
        $header = $this->getAcceptLanguageHeader($request);

        if (! $header) {
            return null;
        }

        $supportedLanguagesLine = implode(',', $supportedLanguages);

        $languageMatch = $header->match($supportedLanguagesLine);

        if (! $languageMatch) {
            return null;
        }

        return $languageMatch;
    }

}

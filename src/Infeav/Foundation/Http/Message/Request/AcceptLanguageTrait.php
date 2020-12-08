<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Http\Message\Request;

use Laminas\Http\Header\AcceptLanguage;
use Psr\Http\Message\ServerRequestInterface;

trait AcceptLanguageTrait
{

    protected function getAcceptLanguageHeader(ServerRequestInterface $request): ?AcceptLanguage
    {
        $headerLine = $request->getHeaderLine('accept-language');

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

}

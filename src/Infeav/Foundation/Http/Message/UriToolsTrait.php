<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

trait UriToolsTrait
{

    protected function getUriWithQueryParams(ServerRequestInterface $request, array $queryParams): UriInterface
    {
        return $request->getUri()->withQuery(http_build_query($queryParams));
    }

    protected function getUriWithAdditionalQueryParams(ServerRequestInterface $request, array $queryParams): UriInterface
    {
        return $this->getUriWithQueryParams($request,
            array_merge($request->getQueryParams(), $queryParams));
    }

}

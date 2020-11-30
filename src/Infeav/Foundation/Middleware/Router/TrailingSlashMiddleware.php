<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Router;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrailingSlashMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestPath = $request->getAttribute('app_request_path');

        if (strlen($requestPath) > 1) {
            if (str_ends_with($requestPath, '/')) {
                $requestPathFinal = rtrim($request->getUri()->getPath(), '/');
                $requestQuery = $request->getUri()->getQuery();

                if ($requestQuery) {
                    $requestPathFinal .= '?' . $requestQuery;
                }

                return new RedirectResponse($requestPathFinal);
            }
        }

        return $handler->handle($request);
    }

}

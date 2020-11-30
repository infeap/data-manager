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

use Infeav\Foundation\Http\Message\Response\StatusCode;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexFilesMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestPath = $request->getAttribute('app_request_path');

        switch ($requestPath) {
            case '/index.html':
            case '/index.php':
            case '/start.php':
                $basePath = $request->getAttribute('app_base_path');

                return new RedirectResponse($basePath . '/', StatusCode::MOVED_PERMANENTLY);
        }

        return $handler->handle($request);
    }

}

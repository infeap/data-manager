<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasePathMiddleware implements MiddlewareInterface
{

    protected $basePath;
    protected $requestPath;

    public function __construct(string $basePath, string $requestPath)
    {
        $this->basePath = $basePath;
        $this->requestPath = $requestPath;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withAttribute('app_base_path', $this->basePath);
        $request = $request->withAttribute('app_request_path', $this->requestPath);

        return $handler->handle($request);
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Helper;

use Infeav\Foundation\Http\Request\Helper\ServerRequestHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ServerRequestMiddleware implements MiddlewareInterface
{

    protected ServerRequestHelper $requestHelper;

    public function __construct(ServerRequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->requestHelper->setRequest($request);

        return $handler->handle($request);
    }

}

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

use Infeav\Foundation\Config\AccessControl;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthHandler implements RequestHandlerInterface
{

    protected $accessControl;

    public function __construct(AccessControl $accessControl)
    {
        $this->accessControl = $accessControl;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->accessControl->findUserMatch($request);

        return new JsonResponse([]);
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Handler\Api\User;

use Infeav\Data\Config\AccessControl;
use Infeav\Data\Config\DataSourceManager;
use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Response\ApiResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticateHandler implements RequestHandlerInterface
{

    public function __construct(
        protected AccessControl $accessControl,
        protected DataSourceManager $dataSourceManager,
    ) { }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $authenticatedUser = $this->accessControl->authenticateUser($request);

        if ($authenticatedUser) {
            return new JsonResponse([
                'user' => [
                    // ToDo: Data
                ],
            ]);
        } else {
            return new ApiResponse([
                'status' => StatusCode::UNAUTHORIZED,
                'key' => 'error.authentication.failed',
                'details' => [
                    'message' => 'The user has not been correctly identified and/or authenticated',
                ],
            ]);
        }
    }

}

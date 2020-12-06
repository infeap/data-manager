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
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionHandler implements RequestHandlerInterface
{

    public function __construct(
        protected AccessControl $accessControl,
        protected DataSourceManager $dataSourceManager,
    ) { }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $sessionUser = $this->accessControl->getSessionUser($request);
        $dataSources = $this->dataSourceManager->getDataSources(forUser: $sessionUser, withPermissionTo: 'read');

        return new JsonResponse([
            'user' => [
                'isAuthenticated' => $sessionUser->isAuthenticated(),
                'offerLogin' => ! $sessionUser->isAuthenticated() && $this->accessControl->offerAuthentication(),
            ],
            'dataSources' => $dataSources->toOverview(),
        ]);
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Handler\Api;

use Infeav\Data\Config\AccessControl;
use Infeav\Data\Config\DataSourcesManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthHandler implements RequestHandlerInterface
{

    protected AccessControl $accessControl;
    protected DataSourcesManager $dataSourcesManager;

    public function __construct(AccessControl $accessControl, DataSourcesManager $dataSourcesManager)
    {
        $this->accessControl = $accessControl;
        $this->dataSourcesManager = $dataSourcesManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $sessionUser = $this->accessControl->getSessionUser($request);
        $dataSources = $this->dataSourcesManager->getDataSourcesWithPermission('read', $sessionUser);

        return new JsonResponse([
            'user' => [
                'isAuthenticated' => $sessionUser->isAuthenticated(),
            ],
            'dataSources' => $dataSources->toResponseArray(),
        ]);
    }

}

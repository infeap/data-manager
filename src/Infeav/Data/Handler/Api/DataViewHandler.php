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
use Infeav\Foundation\Http\Response\ApiResponse;
use Infeav\Foundation\Http\Response\ApiResponseException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DataViewHandler implements RequestHandlerInterface
{
    use DataPathTrait;

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

        try {
            $dataPathSegments = $this->getDataPathSegments($request);
            $requestedDataSource = $this->getRequestedDataSource($dataPathSegments, $dataSources);
            $requestedDataView = $this->getRequestedDataView($dataPathSegments, $requestedDataSource);
        } catch (ApiResponseException $exception) {
            return new ApiResponse($exception->getApiResponseOptions());
        }

        return new JsonResponse([
            'partials' => $requestedDataView->getPartials()->toResponse(),
            'hasAnnotationsSupport' => $requestedDataSource->hasAnnotationsSupport(),
        ]);
    }

}

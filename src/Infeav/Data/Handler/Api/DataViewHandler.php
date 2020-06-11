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
use Infeav\Data\Config\DataSource;
use Infeav\Data\Config\DataSourcesManager;
use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Response\ApiResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DataViewHandler implements RequestHandlerInterface
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

        $dataPath = $request->getQueryParams()['path'] ?? null;

        if ($dataPath === null) {
            return new ApiResponse([
                'status' => StatusCode::BAD_REQUEST,
                'key' => 'error.data_view.data_path.missing',
                'details' => [
                    'message' => 'The "path" query param is required but missing',
                ],
            ]);
        }

        $dataPath = trim($dataPath, ' /');

        if (! $dataPath) {
            return new ApiResponse([
                'status' => StatusCode::BAD_REQUEST,
                'key' => 'error.data_view.data_path.empty',
                'details' => [
                    'message' => 'The "path" query param is empty, but must contain at least one segment',
                ],
            ]);
        }

        $dataPathSegments = explode('/', $dataPath);

        $requestedDataSource = null;

        /** @var DataSource $dataSource */
        foreach ($dataSources as $dataSource) {
            if ($dataSource->getId() === $dataPathSegments[0]) {
                $requestedDataSource = $dataSource;
                break;
            }
        }

        if (! $requestedDataSource) {
            return new ApiResponse([
                'status' => StatusCode::NOT_FOUND,
                'key' => 'error.data_view.not_found',
                'details' => [
                    'message' => 'The requested data source has not been found',
                    'dataSource' => $dataPathSegments[0],
                ],
            ]);
        }

        if (count($dataPathSegments) == 1) {
            $requestedDataView = $requestedDataSource;
        } else {
            $requestedDataView = $requestedDataSource;

            for ($i = 1; $i < count($dataPathSegments); $i++) {

                // ToDo: Check permissions, if data paths are used for access control
                $subView = $requestedDataView->findSubView($dataPathSegments[$i]);

                if ($subView) {
                    $requestedDataView = $subView;
                } else {
                    return new ApiResponse([
                        'status' => StatusCode::NOT_FOUND,
                        'key' => 'error.data_view.not_found',
                        'details' => [
                            'message' => 'The requested data view has not been found',
                            'dataView' => $dataPathSegments[$i],
                        ],
                    ]);
                }
            }
        }

        return new JsonResponse([
            'partials' => $requestedDataView->getPartials()->toResponse(),
            'hasAnnotationsSupport' => $requestedDataSource->hasAnnotationsSupport(),
        ]);
    }

}

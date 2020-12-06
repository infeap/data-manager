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

use Infeav\Data\Config\DataSource;
use Infeav\Data\Config\DataSourceList;
use Infeav\Data\Config\DataView;
use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Response\ApiResponseException;
use Psr\Http\Message\ServerRequestInterface;

trait DataPathTrait
{

    protected function getDataPathSegments(ServerRequestInterface $request): array
    {
        $dataPath = $request->getQueryParams()['data-path'] ?? null;

        if ($dataPath === null) {
            throw new ApiResponseException([
                'status' => StatusCode::BAD_REQUEST,
                'key' => 'error.data_view.data_path.missing',
                'details' => [
                    'message' => 'The "path" query param is required but missing',
                ],
            ]);
        }

        $dataPath = trim($dataPath, ' /');

        if (! $dataPath) {
            throw new ApiResponseException([
                'status' => StatusCode::BAD_REQUEST,
                'key' => 'error.data_view.data_path.empty',
                'details' => [
                    'message' => 'The "path" query param is empty, but must contain at least one segment',
                ],
            ]);
        }

        $dataPathSegments = explode('/', $dataPath);

        return $dataPathSegments;
    }

    protected function getRequestedDataSource(array $dataPathSegments, DataSourceList $dataSources): DataSource
    {
        $requestedDataSource = null;

        /** @var DataSource $dataSource */
        foreach ($dataSources as $dataSource) {
            if ($dataSource->getSlug() === $dataPathSegments[0]) {
                $requestedDataSource = $dataSource;
                break;
            }
        }

        if (! $requestedDataSource) {
            throw new ApiResponseException([
                'status' => StatusCode::NOT_FOUND,
                'key' => 'error.data_view.not_found',
                'details' => [
                    'message' => 'The requested data source has not been found or access is not permitted',
                    'dataSource' => $dataPathSegments[0],
                ],
            ]);
        }

        return $requestedDataSource;
    }

    protected function getRequestedDataView(array $dataPathSegments, DataSource $requestedDataSource): DataView
    {
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
                    throw new ApiResponseException([
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

        return $requestedDataView;
    }

}

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
use Infeav\Data\Config\DataPartial\FieldsPartial;
use Infeav\Data\Config\DataSourceManager;
use Infeav\Foundation\Http\Response\ApiResponse;
use Infeav\Foundation\Http\Response\ApiResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DataFieldsHandler implements RequestHandlerInterface
{
    use DataPathTrait;

    public function __construct(
        protected AccessControl $accessControl,
        protected DataSourceManager $dataSourceManager,
    ) { }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'POST':
                $actionType = 'create';
                break;
            case 'PATCH':
                $actionType = 'edit';
                break;
            default:
                $actionType = '?';
        }

        $sessionUser = $this->accessControl->getSessionUser($request);
        $dataSources = $this->dataSourceManager->getDataSources(forUser: $sessionUser, withPermissionTo: $actionType);

        try {
            $dataPathSegments = $this->getDataPathSegments($request);
            $requestedDataSource = $this->getRequestedDataSource($dataPathSegments, $dataSources);
            $requestedDataView = $this->getRequestedDataView($dataPathSegments, $requestedDataSource);
        } catch (ApiResponseException $exception) {
            return new ApiResponse($exception->getApiResponseOptions());
        }

        $fields = $request->getParsedBody();

        if (! is_array($fields) || empty($fields)) {
            return new ApiResponse([
                // ToDo
            ]);
        }

        foreach ($requestedDataView->getDataPartials() as $dataPartial) {
            if ($dataPartial instanceof FieldsPartial) {
                $dataPartial->getEventManager()->trigger($actionType . '_fields', $dataPartial, $fields);
            }
        }

        // ToDo: Return result
    }

}

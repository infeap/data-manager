<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Handler\Api;

use Infeap\Foundation\Http\Message\Response\StatusCode;
use Infeap\Foundation\Http\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new ApiResponse([
            'status' => StatusCode::NOT_FOUND,
            'key' => 'error.404',
            'debug' => [
                'message' => 'The requested API endpoint has not been found',
            ],
        ]);
    }

}

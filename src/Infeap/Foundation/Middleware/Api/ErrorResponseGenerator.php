<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Middleware\Api;

use Infeap\Foundation\Http\Message\Response\StatusCode;
use Infeap\Foundation\Http\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorResponseGenerator
{

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return new ApiResponse([
            'status' => StatusCode::INTERNAL_SERVER_ERROR,
            'headers' => [
                'Inf-Error-ID' => uniqid(),
            ],
            'key' => 'error.500',
            'debug' => [
                'error' => $error,
            ],
        ]);
    }

}

<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Api;

use Infeav\Foundation\Http\Message\Response\StatusCode;
use Infeav\Foundation\Http\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorResponseGenerator
{

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return new ApiResponse([
            'status' => StatusCode::INTERNAL_SERVER_ERROR,
            'headers' => [
                'inf-error-id' => uniqid(),
            ],
            'key' => 'error.500',
            'debug' => [
                'error' => $error,
            ],
        ]);
    }

}

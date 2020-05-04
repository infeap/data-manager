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

use Infeap\Foundation\Http\Response\ApiResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiResponseMiddleware implements MiddlewareInterface
{

    protected $isDebugMode;

    public function __construct(bool $isDebugMode)
    {
        $this->isDebugMode = $isDebugMode;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if ($response instanceof ApiResponse) {
            $responseData = [];

            if ($response->getKey()) {
                $responseData['key'] = $response->getKey();
            }

            if ($response->getDetails()) {
                $responseData['details'] = $response->getDetails();
            }

            if ($this->isDebugMode) {
                $responseData['debug'] = $response->getDebug();

                $exception = $responseData['debug']['exception'] ?? null;

                if ($exception && $exception instanceof \Throwable) {
                    $parseException = function (\Throwable $exception) use (&$parseException): array {
                        $exceptionData = [
                            'type' => get_class($exception),
                            'message' => $exception->getMessage(),
                            'code' => $exception->getCode(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                            'trace' => $exception->getTrace(),
                        ];

                        $previousException = $exception->getPrevious();

                        if ($previousException) {
                            $exceptionData['previous'] = $parseException($previousException);
                        }

                        return $exceptionData;
                    };

                    $responseData['debug']['exception'] = $parseException($exception);
                }
            }

            $response = new JsonResponse(
                $responseData,
                $response->getStatusCode(),
                $response->getHeaders(),
            );
        }

        return $response;
    }

}

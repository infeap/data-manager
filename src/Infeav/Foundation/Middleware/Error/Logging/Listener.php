<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Middleware\Error\Logging;

use Infeav\Foundation\Log\LogManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Listener
{

    public function __construct(
        protected LogManager $logManager,
        protected string $appDir,
    ) { }

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response)
    {
        $createLogDetails = function (\Throwable $error) use (&$createLogDetails, $request, $response): array {
            $logDetails = [
                'id' => $response->getHeaderLine('inf-error-id'),
                'timestamp' => date('Y-m-d H:i:s T'),
                'request' => [
                    'method' => $request->getMethod(),
                    'uri' => (string) $request->getUri(),
                ],
                'message' => $error->getMessage(),
                'type' => $error::class,
                'code' => $error->getCode(),
                'file' => str_replace($this->appDir . '/', '', $error->getFile()),
                'line' => $error->getLine(),
            ];

            $previousError = $error->getPrevious();

            if ($previousError) {
                $logDetails['previous'] = $createLogDetails($previousError);
            }

            return $logDetails;
        };

        $logDetails = $createLogDetails($error);

        $this->logManager->logError($logDetails);
    }

}

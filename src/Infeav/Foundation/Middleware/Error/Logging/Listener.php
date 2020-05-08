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

use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Listener
{

    protected $logDir;
    protected $appDir;

    public function __construct(string $logDir, string $appDir)
    {
        $this->logDir = $logDir;
        $this->appDir = $appDir;
    }

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response)
    {
        $logFile = sprintf('%s/errors.json',
            $this->logDir);

        $log = [];

        if (is_file($logFile) && is_readable($logFile)) {
            $log = Json::decode(file_get_contents($logFile), Json::TYPE_ARRAY);
        }

        $createLogEntry = function (\Throwable $error) use (&$createLogEntry, $request, $response): array {
            $logEntry = [
                'id' => $response->getHeaderLine('Inf-Error-ID'),
                'time' => date('Y-m-d H:i:s T'),
                'request' => [
                    'method' => $request->getMethod(),
                    'uri' => (string) $request->getUri(),
                ],
                'message' => $error->getMessage(),
                'type' => get_class($error),
                'code' => $error->getCode(),
                'file' => str_replace($this->appDir . '/', '', $error->getFile()),
                'line' => $error->getLine(),
            ];

            $previousError = $error->getPrevious();

            if ($previousError) {
                $logEntry['previous'] = $createLogEntry($previousError);
            }

            return $logEntry;
        };

        $log[] = $createLogEntry($error);

        if ((is_file($logFile) && is_writable($logFile)) ||
            (! is_file($logFile) && is_writable(dirname($logFile)))) {

            $logJson = Json::prettyPrint(Json::encode($log));
            $logJson = str_replace('\/', '/', $logJson);

            file_put_contents($logFile, $logJson);
        }
    }

}

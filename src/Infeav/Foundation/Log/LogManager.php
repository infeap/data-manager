<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Foundation\Log;

use Infeav\Foundation\I18n\LanguageService;
use Laminas\Code\Generator\ValueGenerator;
use Laminas\Json\Json;

class LogManager
{

    protected string $logDir;
    protected string $appDir;
    protected LanguageService $languageService;

    public function __construct(string $logDir, string $appDir, LanguageService $languageService)
    {
        $this->logDir = $logDir;
        $this->appDir = $appDir;
        $this->languageService = $languageService;
    }

    public function logDebug($details, string $subName = 'general'): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        $logFileName = sprintf('debug/%s',
            $subName);

        return $this->writeToLogFile($logFileName, 'php', $details);
    }

    public function logError($details): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('errors', 'json', $details);
    }

    public function logMissingTranslation(string $key, ?string $textDomain = null, ?string $languageTag = null): bool
    {
        if (! $textDomain) {
            $textDomain = 'Unspecified (probably "foundation")';
        }

        if (! $languageTag) {
            $languageTag = $this->languageService->getCurrentLanguage();
        }

        return $this->writeToLogFile('missing-translations', 'json', [
            'key' => $key,
            'textDomain' => $textDomain,
            'languageTag' => $languageTag,
        ], function (array $log) use ($key): bool {
            return ! array_filter($log, function ($logEntry) use ($key) {
                if (is_array($logEntry)) {
                    $logEntryKey = $logEntry['key'] ?? null;

                    if ($logEntryKey && $logEntryKey == $key) {
                        return true;
                    }
                }

                return false;
            });
        });
    }

    public function logWarning($details): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('warnings', 'json', $details);
    }

    protected function normalizeLogDetails($details): ?array
    {
        if (is_scalar($details)) {
            $details = [
                'content' => $details,
            ];
        } else if ($details instanceof \Throwable) {
            $createErrorDetails = function (\Throwable $error) use (&$createErrorDetails): array {
                $logDetails = [
                    'time' => date('Y-m-d H:i:s T'),
                    'message' => $error->getMessage(),
                    'type' => get_class($error),
                    'code' => $error->getCode(),
                    'file' => str_replace($this->appDir . '/', '', $error->getFile()),
                    'line' => $error->getLine(),
                ];

                $previousError = $error->getPrevious();

                if ($previousError) {
                    $logDetails['previous'] = $createErrorDetails($previousError);
                }

                return $logDetails;
            };

            $details = [
                'error' => $createErrorDetails($details),
            ];
        }

        if (! is_array($details)) {
            return null;
        }

        if (! isset($details['time'])) {
            $details = ['time' => date('Y-m-d H:i:s T')] + $details;
        }

        return $details;
    }

    protected function writeToLogFile(string $name, string $type, array $entry, ?callable $condition = null): bool
    {
        $logFile = sprintf('%s/%s.%s',
            $this->logDir, $name, $type);

        $log = [];

        if (is_file($logFile) && is_readable($logFile)) {
            switch ($type) {
                case 'json':
                    $log = Json::decode(file_get_contents($logFile), Json::TYPE_ARRAY);
                    break;
                case 'php':
                    $log = include $logFile;
                    break;
            }
        }

        if ($condition) {
            if (! $condition($log)) {
                return false;
            }
        }

        $log[] = $entry;

        if ((is_file($logFile) && is_writable($logFile)) ||
            (! is_file($logFile) && is_writable(dirname($logFile)))) {

            switch ($type) {
                case 'json':
                    $logContent = Json::encode($log, true, ['prettyPrint' => true]);
                    $logContent = str_replace('\/', '/', $logContent);
                    break;
                case 'php':
                    $logContent = "<?php\n\nreturn " . (new ValueGenerator($log)) . ";\n";
                    break;
                default:
                    $logContent = null;
            }

            if ($logContent) {
                return (bool) file_put_contents($logFile, $logContent);
            }
        }

        return false;
    }

}

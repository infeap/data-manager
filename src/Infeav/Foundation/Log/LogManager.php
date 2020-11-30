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

    public function __construct(
        protected string $logDir,
        protected string $appDir,
        protected LanguageService $languageService,
    ) { }

    public function logDebug(mixed $details, string $fileName = 'general'): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('debug/' . $fileName, fileType: 'php', entry: $details);
    }

    public function logInfo(mixed $details): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('infos', fileType: 'json', entry: $details);
    }

    public function logWarning(mixed $details): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('warnings', fileType: 'json', entry: $details);
    }

    public function logError(mixed $details): bool
    {
        $details = $this->normalizeLogDetails($details);

        if (! $details) {
            return false;
        }

        return $this->writeToLogFile('errors', fileType: 'json', entry: $details);
    }

    public function logMissingTranslation(string $key, ?string $textDomain = null, ?string $languageTag = null): bool
    {
        if (! $textDomain) {
            $textDomain = 'Unspecified (probably "foundation")';
        }

        if (! $languageTag) {
            $languageTag = $this->languageService->getCurrentLanguage();
        }

        return $this->writeToLogFile('missing-translations', fileType: 'json', entry: [
            'key' => $key,
            'text-domain' => $textDomain,
            'language-tag' => $languageTag,
        ], condition: function (array $log) use ($key): bool {

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

    protected function normalizeLogDetails(mixed $details): ?array
    {
        if (is_scalar($details)) {
            $details = [
                'content' => $details,
            ];
        } else if ($details instanceof \Throwable) {
            $createErrorDetails = function (\Throwable $error) use (&$createErrorDetails): array {
                $logDetails = [
                    'timestamp' => date('Y-m-d H:i:s T'),
                    'message' => $error->getMessage(),
                    'type' => $error::class,
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

        if (! isset($details['timestamp'])) {
            $details = ['timestamp' => date('Y-m-d H:i:s T')] + $details;
        }

        return $details;
    }

    protected function writeToLogFile(string $fileName, string $fileType, array $entry, ?callable $condition = null): bool
    {
        $filePath = sprintf('%s/%s.%s',
            $this->logDir, $fileName, $fileType);

        $log = [];

        if (is_file($filePath) && is_readable($filePath)) {
            switch ($fileType) {
                case 'json':
                    $log = Json::decode(file_get_contents($filePath), Json::TYPE_ARRAY);
                    break;
                case 'php':
                    $log = include $filePath;
                    break;
            }
        }

        if ($condition) {
            if (! $condition($log)) {
                return false;
            }
        }

        $log[] = $entry;

        if ((is_file($filePath) && is_writable($filePath)) ||
            (! is_file($filePath) && is_writable(dirname($filePath)))) {

            switch ($fileType) {
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
                return (bool) file_put_contents($filePath, $logContent);
            }
        }

        return false;
    }

}

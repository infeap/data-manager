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
use Laminas\Json\Json;

class LogManager
{

    protected string $logDir;
    protected LanguageService $languageService;

    public function __construct(string $logDir, LanguageService $languageService)
    {
        $this->logDir = $logDir;
        $this->languageService = $languageService;
    }

    public function logError(array $details): void
    {
        $this->writeToLogFile('errors', 'json', $details);
    }

    public function logMissingTranslation(string $key, ?string $textDomain = null, ?string $languageTag = null): void
    {
        if (! $textDomain) {
            $textDomain = 'Unspecified (probably "foundation")';
        }

        if (! $languageTag) {
            $languageTag = $this->languageService->getCurrentLanguage();
        }

        $this->writeToLogFile('missing-translations', 'json', [
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

    protected function writeToLogFile(string $name, string $type, array $entry, ?callable $condition = null): void
    {
        $logFile = sprintf('%s/%s.%s',
            $this->logDir, $name, $type);

        $log = [];

        if (is_file($logFile) && is_readable($logFile)) {
            switch ($type) {
                case 'json':
                    $log = Json::decode(file_get_contents($logFile), Json::TYPE_ARRAY);
                    break;
            }
        }

        if ($condition) {
            if (! $condition($log)) {
                return;
            }
        }

        $log[] = $entry;

        if ((is_file($logFile) && is_writable($logFile)) ||
            (! is_file($logFile) && is_writable(dirname($logFile)))) {

            switch ($type) {
                case 'json':
                    $logContent = Json::prettyPrint(Json::encode($log));
                    $logContent = str_replace('\/', '/', $logContent);
                    break;
                default:
                    $logContent = null;
            }

            if ($logContent) {
                file_put_contents($logFile, $logContent);
            }
        }
    }

}

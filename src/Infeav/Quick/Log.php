<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

use Infeav\Foundation\Log\LogManager;

class InfeavQuickLog
{

    protected static ?LogManager $logManager = null;

    public static function setLogManager(LogManager $logManager): void
    {
        static::$logManager = $logManager;
    }

    public static function logDebug(mixed $details, string $fileName = 'general'): bool
    {
        if (! static::$logManager) {
            return false;
        }

        return static::$logManager->logDebug($details, $fileName);
    }

    public static function logInfo(mixed $details): bool
    {
        if (! static::$logManager) {
            return false;
        }

        return static::$logManager->logInfo($details);
    }

    public static function logWarning(mixed $details): bool
    {
        if (! static::$logManager) {
            return false;
        }

        return static::$logManager->logWarning($details);
    }

    public static function logError(mixed $details): bool
    {
        if (! static::$logManager) {
            return false;
        }

        return static::$logManager->logError($details);
    }

}

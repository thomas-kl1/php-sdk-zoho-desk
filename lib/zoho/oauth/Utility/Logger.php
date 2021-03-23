<?php declare(strict_types=1);

namespace Zoho\OAuth\Utility;

use function constant;
use function defined;

class Logger
{
    public const LOG_FILENAME = 'zoho_oauth.log';

    public static function warn($msg): void
    {
        self::writeToFile("WARNING: $msg");
    }

    public static function writeToFile($msg): void
    {
        $path = defined('LOGGER_PATH') ? constant('LOGGER_PATH') : __DIR__ . '/../../../../';
        $filePointer = fopen($path . self::LOG_FILENAME, 'ab');
        if (!$filePointer) {
            return;
        }
        fwrite($filePointer, sprintf("%s %s\n", date('Y-m-d H:i:s'), $msg));
        fclose($filePointer);
    }

    public static function info($msg): void
    {
        self::writeToFile("INFO: $msg");
    }

    public static function severe($msg): void
    {
        self::writeToFile("SEVERE: $msg");
    }

    public static function err($msg): void
    {
        self::writeToFile("ERROR: $msg");
    }

    public static function debug($msg): void
    {
        self::writeToFile("DEBUG: $msg");
    }
}
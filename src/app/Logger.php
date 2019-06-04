<?php
declare(strict_types=1);


namespace App;

use DateTime;
use Exception;

/**
 * Class Logger
 *
 * @package App
 */
class Logger
{

    /**
     * @param string $message
     *
     * @throws Exception
     */
    static public function write(string $message): void
    {
        $dateTime = new DateTime();

        $dirPath = __DIR__ . '/../logs';
        $filePath = "$dirPath/log@" . $dateTime->format('Y-m-d') . " . log";

        if (!file_exists($dirPath) || !is_dir($dirPath)) {
            mkdir($dirPath, 777);
        }

        $file = fopen($filePath, 'a+');
        fwrite($file, $dateTime->format('d.m.Y H:i:s') . " | $message | \n");
        fclose($file);
    }
}
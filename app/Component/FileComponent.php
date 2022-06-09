<?php

namespace App\Component;

/**
 * Класс компонент для работы с файлом
 */
class FileComponent
{
    private const PATH_APP = "/var/www/html";

    /**
     * Открыть лог файл
     * @return false|resource
     */
    public function openFile()
    {
        return fopen(self::PATH_APP . "/resources/data/access_log_large", "r");
    }

    /**
     * Получить данные из лог файла
     * @param $path
     * @return array
     */
    public function getDataFromLogFile($path): array
    {
        $fileData = [];
        while (!feof($path)) {
            $buffer = fgets($path, 4096);
            if ($buffer) {
                $array = explode('/n', $buffer);
                $pattern = "/(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) (\".*?\") (\".*?\")/";
                foreach ($array as $item) {
                    preg_match($pattern, $item, $fileData[]);
                }
            }
        }
        fclose($path);
        return $fileData;
    }
}

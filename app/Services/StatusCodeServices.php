<?php

namespace App\Services;

/**
 * Класс компонент для работы с статус кодом
 */
class StatusCodeServices
{
    /**
     * Указать все статус коды
     *
     * @param $fileData
     * @return array
     */
    public function setStatusCode($fileData): array
    {
        $statusCodes = [];
        $codes = array_unique(array_column($fileData, 10));

        foreach ($codes as $code) {
            $statusCodes[$code] = 0;
        }

        return $statusCodes;
    }

    /**
     * Подсчитать Статус коды
     * @param $format
     * @param $statusCodes
     * @return mixed
     */
    public static function countStatusCode($format, $statusCodes): mixed
    {
        if ($format[10]) {
            foreach ($statusCodes as $key => $value) {
                if ($key == $format[10]) {
                    $statusCodes[$key] += 1;
                }
            }
        }
        return $statusCodes;
    }
}

<?php

namespace App\Services;

use App\Component\FileComponent as File;
use App\Component\StatusCodeComponent as StatusCode;

/**
 * Сервисе класс для обработки http access_log файла
 */
class AccessLogServices
{
    public const CRAWLERS_GOOGLE = 'Googlebot';
    public const CRAWLERS_BING = 'Bingbot';
    public const CRAWLERS_BAIDU = 'Baiduspider';
    public const CRAWLERS_YANDEX = 'YandexBot';

    /**
     * количество запросов от поисковиков
     * @var array|int[]
     */
    public array $crawlers = [
        'Google' => 0,
        'Bing' => 0,
        'Baidu' => 0,
        'Yandex' => 0
    ];

    /** @var int объем трафика*/
    public int $trafficAccessLogFile = 0;

    /** @var File компонента файла*/
    private File $_file;

    /** @var StatusCode компонента статус кода*/
    private StatusCode $_statusCode;

    /**
     * Создание экземпляра.
     *
     * @param File $file
     * @param StatusCode $statusCode
     */
    public function __construct(File $file, StatusCode $statusCode)
    {
        $this->_file = $file;
        $this->_statusCode = $statusCode;
    }

    /**
     * Обработка http access_log файла.
     *
     * @return array
     */
    public function handle(): array
    {
        $file = $this->_file->openFile();
        $result = [];
        if ($file) {
            $fileData = $this->_file->getDataFromLogFile($file);
            $urls = array_unique(array_column($fileData, 8));
            $statusCodes = $this->_statusCode->setStatusCode($fileData);

            foreach ($fileData as $format) {
                if ($format) {
                    $this->trafficAccessLogFile += (int)$format[11];

                    if (str_contains($format[13], self::CRAWLERS_GOOGLE)) {
                        $this->crawlers['Google'] += 1;
                    }

                    if (str_contains($format[13], self::CRAWLERS_BING)) {
                        $this->crawlers['Bing'] += 1;
                    }

                    if (str_contains($format[13], self::CRAWLERS_BAIDU)) {
                        $this->crawlers['Baidu'] += 1;
                    }

                    if (str_contains($format[13], self::CRAWLERS_YANDEX)) {
                        $this->crawlers['Yandex'] += 1;
                    }

                    $statusCodes = $this->_statusCode::countStatusCode($format, $statusCodes);
                }
            }

            $result = [
                'views' => count($fileData),
                'urls' => count($urls),
                'traffic' => $this->trafficAccessLogFile,
                'crawlers' => $this->crawlers,
                'statusCodes' => $statusCodes,
            ];
        }
        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\Component\AccessLogComponent;
use App\Services\FileServices;
use App\Services\StatusCodeServices;
use Illuminate\Http\JsonResponse;

class AccessLogController extends Controller
{
    /**
     * Получить статистику по http access_log файлу в json
     * @return JsonResponse
     */
    public function getAccessLog(): JsonResponse
    {
        $fileComponent = new FileServices();
        $statusCodeComponent = new StatusCodeServices();
        $accessLog = new AccessLogComponent($fileComponent, $statusCodeComponent);
        $data = $accessLog->handle();

        return response()->json($data);
    }

}

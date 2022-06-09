<?php

namespace App\Http\Controllers;

use App\Component\FileComponent;
use App\Services\AccessLogServices;
use App\Component\StatusCodeComponent;
use Illuminate\Http\JsonResponse;

class AccessLogController extends Controller
{
    /**
     * Получить статистику по http access_log файлу в json
     * @return JsonResponse
     */
    public function getAccessLog(): JsonResponse
    {
        $fileComponent = new FileComponent();
        $statusCodeComponent = new StatusCodeComponent();
        $accessLog = new AccessLogServices($fileComponent, $statusCodeComponent);
        $data = $accessLog->handle();

        return response()->json($data);
    }

}

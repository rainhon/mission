<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RequestLog as RequestLogModel;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 记录请求
        $date = date('Y_m_d');
        $request->merge(['request_id' => uniqid()]);
        $requestData = $request->all() ? json_encode($request->all(), JSON_UNESCAPED_UNICODE) : '';
        $log = new RequestLogModel();
        $log->setTableName($date);
        $log->method = $request->method();
        $log->request_id = $request->request_id;
        $log->request_path = $request->path();
        $log->request_data = substr($requestData, 0, 2000);
        $response = $next($request);
        // 记录返回
        $log->response_data = substr($response->getContent(), 0, 2000);
        $log->save();
        return $response;
    }
}

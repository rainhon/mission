<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 返回成功
     * @param string|array|null $data
     * @return array
     */
    public function success(null|string|array $data = null): array
    {
        return [
            'code' => 200,
            'data' => $data
        ];
    }

    /**
     * 返回成功
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error(string $message, int $code = 600): array
    {
        return [
            'code' => $code,
            'message' => $message
        ];
    }
}

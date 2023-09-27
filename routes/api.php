<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/return-request', function (Request $request) {
    return $request->all();
});

Route::get('/validate-exception', function (Request $request) {
    $request->validate(['test' => 'required']);
});

Route::get('/error', function () {
    1 / 0;
});

Route::get('/test', function (Request $request) {
    $s = $request->s;
    $length = strlen($s);
    if ($length <= 1 || $length >= 10000) {
        return ['code' => 500, 'message' => 'invalidate length'];
    }
    $chars = ['(', ')', '[', ']', '{', '}'];
    $stack = [];
    $result = true;
    for ($i = 0; $i < $length; $i++) {
        $index = array_search($s[$i], $chars);
        if ($index === false) {
            return ['code' => 500, 'data' => 'invalidate character'];
        }
        if ($index % 2 == 0) {
            $stack[] = $s[$i];
        } else {
            if (array_pop($stack) !== $chars[$index - 1]) {
                $result = false;
                break;
            }
        }
    }
    if (!empty($stack)) {
        $result = false;
    }
    return ['code' => 200, 'data' => $result];
});

<?php

namespace App\Exceptions;

use App\Models\ExceptionLog;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            $log = new ExceptionLog();
            $log->setTableName(date('Y_m_d'));
            $log->exception = get_class($e);
            $log->message = $e->getMessage();
            $log->trace = substr($e->getTraceAsString(), 0, 2000);
            $log->request_id = request()->request_id ?: null;
            $log->save();

            if (env('APP_DEBUG')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            } else {
                if ($e instanceof \Exception) {
                    return response()->json([
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ], 500);
                }
                return response()->json([
                    'code' => 500,
                    'message' => 'Internal Server Error'
                ], 500);
            }
        });
    }
}

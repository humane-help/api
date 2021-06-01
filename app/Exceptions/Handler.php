<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $exception->getMessage();

        if ($exception->getCode()) {
            $status = $exception->getCode();
        }

        if (!Arr::get(Response::$statusTexts, $status))
        {
            if (app()->environment(['production', 'prod'])) {
                $message = 'Sorry! Looks like we have a problem on the server. Please try again later.';
            }
            $status = 500;
        }

        $response = [
            'code' => $status,
            'type' => 'error',
            'message' => $message
        ];

        return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

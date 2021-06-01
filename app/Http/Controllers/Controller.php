<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get default error.
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getDefaultError()
    {
        return trans('words.default_error_message');
    }

    /**
     * Get formatted error.
     *
     * @param  string  $message
     * @return JsonResponse
     */
    protected function error($status = '', $message = '')
    {
        if (empty($message)) {
            $message = $this->getDefaultError();
        };
        if (!$status) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        };

        return response()->json([
            'type' => 'error',
            'code' => 50000,
            'message'=> $message
        ], $status);
    }

    /**
     * @param $error
     * @return JsonResponse
     */
    protected function showError($error)
    {
        return response()->json(['error'=>$error['code'], 'message'=>$error['message']]);
    }

    /**
     * @param $entityName
     * @param null $object
     * @param string $message
     * @param int $status
     * @return array
     */
    protected function successResponse(
        $entityName,
        $object = null,
        $message = 'OK',
        $status = 20000
    )
    {
        $response = [
            'code' => $status,
            'type' => 'success',
            'message' => $message,
            'payload' => [
                Str::camel($entityName) => $object
            ]
        ];
        return $response;
    }
    /**
     * @param $entityName
     * @param null $object
     * @param string $type
     * @param string $message
     * @param int $status
     * @return array
     */
    protected function errorResponse(
        $entityName,
        $object = null,
        $type = 'error',
        $message = 'Error',
        $status = 50000
    )
    {
        $response = [
            'code' => $status,
            'type' => $type,
            'message' => $message,
            'payload' => [
                Str::camel($entityName) => $object
            ]
        ];
        return $response;
    }

}

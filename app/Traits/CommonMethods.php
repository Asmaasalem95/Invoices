<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait CommonMethods
{
    /**
     * Return API response with message, data and status code.
     *
     * @param $message
     * @param $code
     * @param $data
     * @return JsonResponse
     */
    public function apiResponse($message, $code, $data = [])
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ])->setStatusCode($code);
    }
}

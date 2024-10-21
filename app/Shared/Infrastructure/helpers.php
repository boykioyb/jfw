<?php

if (!function_exists('response_success')) {
    function response_success($data = null, $message = "Thành công"): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => 0,
            'message' => $message,
            'data' => $data
        ]);
    }
}

if (!function_exists('response_error')) {
    function response_error($message = "Có lỗi xảy ra", $code = -1, $data = null, $httpCode = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }
}

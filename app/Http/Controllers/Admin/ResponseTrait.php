<?php

namespace App\Http\Controllers\Admin;

trait ResponseTrait
{
    public function sendResponse($result = null, $msg = '')
    {
        $response = [
            'success' => 200,
            'data' => $result,
            'message' => $msg,
        ];
        return response()->json($response, 200);
    }
    public function sendError($erorr, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'data' => $erorr,
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
    public function sendErrorWithoutData($erorr, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $erorr,
        ];
        return response()->json($response, $code);
    }
    public function sendResponseWithoutData($success, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $success,
        ];
        return response()->json($response, $code);
    }
}

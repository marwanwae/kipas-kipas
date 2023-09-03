<?php

namespace App\Helper;

class FormatResponse {
        /**
     * untuk generate response success api
     * @param array $data
     * @param string $responseCode
     */
    public static function  responseSuccess($responseCode, $responseMessage, $responseData){

        $result = [
            "response_code" => $responseCode,
            "response_message" => $responseMessage,
            "response_data" => $responseData
        ];

        return response()->json($result, 200);
    }

    /**
     * untuk generate response failed api
     * @param array $errors
     * @param string $responseCode
     */

    public static function responseFailed($responseCode,  $responseMessage = "INTERNAL SERVER ERROR", $responseError = [], $statusCode = 500){
        $result = [
            "responseCode" => $responseCode,
            "responseMessage" => $responseMessage,
            "errorDetail" => $responseError
        ];

        return response()->json($result, $statusCode);
    }
}
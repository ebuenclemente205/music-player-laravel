<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use App\Enums\ErrorCode;

trait ResponseTrait
{
    /**
     * Return a success response with data.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'error_code' => null,
        ], $status);
    }

    /**
     * Return an error response.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  int  $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message, int $status = 400, string $errorCode = ErrorCode::GENERAL_ERROR): JsonResponse
    {
        return response()->json([
            'message' => $message ?? ErrorCode::getDescription($errorCode),
            'data' => null,
            'error_code' => $errorCode,
        ], $status);
    }

    /**
     * Return a response with empty data.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  int  $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function emptyDataResponse(string $message = 'No Content', int $status = 204, string $errorCode = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => null,
            'error_code' => $errorCode,
        ], $status);
    }

    /**
     * Return a success response with access token.
     *
     * @param  string  $token
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponseWithToken(string $token, $data, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'error_code' => null,
        ], $status);
    }
}

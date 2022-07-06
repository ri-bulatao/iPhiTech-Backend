<?php

declare(strict_types=1);

namespace App\Utilities;

use Illuminate\Http\JsonResponse;

/**
 * Utility class with static functions that returns a `JsonResponse`.
 */
class Result
{
    /**
     * Default success response for requests with code 200.
     */
    public function success($data = null, string $message = 'Success', $total = 0, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'total'   => $total,
        ], $code);
    }

    /**
     * Success response that returns a response with status 201. Use this when something has been created successfully.
     *
     * @param null $data
     */
    public function created($data = null, string $message = 'Created'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], 201);
    }

    /**
     * Error response that returns a response with status 422. Use this for validation errors.
     *
     * @param null $data
     */
    public function validationError($data = null, string $message = 'Validation error'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ], 422);
    }

    /**
     * Error response for results with code 400.
     *
     * @param null $data
     */
    public function badRequest($data = null, string $message = 'Bad request'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ], 400);
    }

    /**
     * Return a response with code 404.
     */
    public function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('messages.request_not_found'),
            'data' => [],
        ], 404);
    }

    /**
     * Return a response with code 401.
     */
    public function unauthorized(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('messages.unauthorized'),
            'data' => [],
        ], 401);
    }

    /**
     * Response with status 500 for unknown exceptions.
     */
    public function exception(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('messages.server_error'),
            'data' => [],
        ], 500);
    }

    /**
     * Customizable json response.
     *
     * @param null $data
     */
    public function custom(bool $success = true, $data = null, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}

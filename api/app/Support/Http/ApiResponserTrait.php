<?php

declare(strict_types=1);

namespace App\Support\Http;

use App\Infrastructure\Http\Requests\Contracts\WithAvailableQueryStringOptionsContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

trait ApiResponserTrait
{
    /**
     * Serialize success response
     *
     * @param mixed       $data
     * @param null|string $message
     * @param bool        $pagination
     * @param int         $code
     * @param null|string $devMessage
     *
     * @return JsonResponse
     */
    public function successResponse(mixed $data, null|string $message = null, bool $pagination = false, int $code = 200, null|string $devMessage = null, null|FormRequest $requestClass = null)
    {
        $others = [];

        if ($requestClass instanceof WithAvailableQueryStringOptionsContract) {
            $others['available_query_strings'] = $requestClass->getQueryStringOptions();
        }

        if ($pagination) {
            $meta = $this->handlePaginationData($data);
            $others['meta'] = $meta;
        }

        $response = [
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
            'others'  => $others
        ];

        if (config('app.env') != 'production') {
            $response['dev_message'] = $devMessage;
        }

        return response()->json($response, $code);
    }

    /**
     * Error specific response
     *
     * @param  null|string $message
     * @param  int         $code
     * @param  null|string $devMessage
     *
     * @return JsonResponse
     */
    public function errorResponse(null|string $message = 'adf', int $code = 500, null|string $devMessage = null)
    {
        $response = [
            'status'  => 'error',
            'message' => $message,
            'data'    => null,
            'code'    => $code,
        ];

        if ($code == 0) {
            $code = 500;
        }

        if (config('app.env') != 'production') {
            $response['dev_message'] = $devMessage;
        }

        return response()->json($response, $code);
    }

    /**
     * Automatic throwable response
     *
     * @param  Throwable   $error
     * @param  int         $code
     * @param  mixed       $data
     * @param  null|string $devMessage
     *
     * @return JsonResponse
     */
    public function throwableResponse(
        Throwable $error,
        int|string $code = 500,
        mixed $data = null,
        null|string $devMessage = null
    ) {
        $message = $error->getMessage();
        $overrideCode = null;
        if (config('app.debug') == false) {
            switch ($error) {
                case $error instanceof \PDOException:
                    $message = 'Something went wrong';
                    $overrideCode = 500;
            }
        }

        $targetCode = null;
        if ($overrideCode == null) {
            if ($error->getCode() == 0) {
                $targetCode = $code;
            } else {
                $targetCode = $error->getCode();
            }
        }

        $response = [
            'status'  => 'error',
            'message' => $message,
            'data'    => $data,
            'code'    => $targetCode == null ? $overrideCode : $targetCode,
        ];

        if (config('app.env') != 'production') {
            $response['dev_message'] = $devMessage;
        }

        return response()->json($response, (int)$code == 0 ? 500 : (int)$code);
    }

    private static function handlePaginationData($data)
    {
        return [
            'total'        => $data->resource->total(),
            'last_page'    => $data->resource->lastPage(),
            'per_page'     => $data->resource->perPage(),
            'current_page' => $data->resource->currentPage(),
            'path'         => $data->resource->path(),
            'query_page'   => $data->resource->getPageName()
        ];
    }
}

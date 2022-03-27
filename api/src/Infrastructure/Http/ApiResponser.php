<?php

declare(strict_types=1);

namespace Infrastructure\Http;

use Throwable;

class ApiResponser
{
    /**
     * Serialize success response
     *
     * @param mixed $data
     * @param string $message
     * @param bool $pagination
     * @param int $code
     * @param string $devMessage
     *
     * @return Response
     */
    public static function successResponse($data, $message = null,  $pagination = false, $code = 200, $devMessage = null)
    {
        $others = [];

        if ($pagination) {
            $meta = self::handlePaginationData($data);
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

    public static function errorResponse($message = null, $code = 500, $devMessage = null)
    {
        $response = [
            'status'  => 'error',
            'message' => $message,
            'data'    => null,
            'code'    => $code,
        ];

        if (config('app.env') != 'production') {
            $response['dev_message'] = $devMessage;
        }

        return response()->json($response, $code);
    }

    public static function throwableResponse(Throwable $error, $code = 500, $data = null, $devMessage = null)
    {
        $message = $error->getMessage();
        $overrideCode = null;
        if (config('app.debug') == false) {
            switch ($error) {
                case $error instanceof \PDOException:
                    $message = 'Something went wrong';
                    $overrideCode = 500;
            }
        }

        $response = [
            'status'  => 'error',
            'message' => $message,
            'data'    => $data,
            'code'    =>  $overrideCode == null ? $error->getCode() : $overrideCode,
        ];

        if (config('app.env') != 'production') {
            $response['dev_message'] = $devMessage;
        }

        return response()->json($response, (int)$code == 0 ? 500 : (int)$code);
    }

    private function handlePaginationData($data)
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

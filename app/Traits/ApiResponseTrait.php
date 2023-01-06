<?php

namespace App\Traits;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait
{
    /**
     * @param JsonResource $resource
     * @param null|string $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResource(JsonResource $resource, string $name = null, string $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'name'    => $name,
                'message' => $message,
                'payload'  => $resource->response()->getData(),
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * @param ResourceCollection $resourceCollection
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResourceCollection(ResourceCollection $resourceCollection, string $name = null, string $message = null, $statusCode = 200, $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'name'    => $name,
                'message' => $message,
                'payload'  => $resourceCollection->response()->getData()
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * Return generic json response with the given data.
     *
     * @param       $data
     * @param int $statusCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function apiResponse($data = [], $statusCode = 200, $headers = []): JsonResponse
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'],
            $result['statusCode'],
            $result['headers']
        );
    }

    /**
     * Description : Used for parsing data success or failed
     *
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return array
     */
    private function parseGivenData(array $data = [], int $statusCode = 200, array $headers = []): array
    {
        $responseStructure = [
            'success' => $data['success'] ?? null,
            'name'    => $data['name'] ?? null,
            'message' => $data['message'] ?? null,
        ];

        if (isset($data['payload'])) {
            $responseStructure['payload'] = $data['payload'] ?? null;
        }

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }

        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }

        /** when response failed */
        if (isset($data['success']) && $data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }

        /**to throw exception */
        if (
            isset($data['exception']) &&
            ($data['exception'] instanceof Error ||
                $data['exception'] instanceof Exception)
        ) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file'    => $data['exception']->getFile(),
                    'line'    => $data['exception']->getLine(),
                    'code'    => $data['exception']->getCode(),
                    'trace'   => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }

        return ["content"    => $responseStructure, "statusCode" => $statusCode, "headers"    => $headers];
    }
}

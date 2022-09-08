<?php 

namespace App\Traits;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

trait ApiResponseTrait {



    // /**
    //  * Return generic json response with the given data.
    //  *
    //  * @param       $data
    //  * @param int $statusCode
    //  * @param array $headers
    //  *
    //  * @return JsonResponse
    //  */
    // protected function apiResponse($data = [], $statusCode = 200, $headers = []):JsonResponse
    // {
    //     $result = $this->parseGivenData($data, $statusCode, $headers);

    //     return response()->json(
    //        $result['content'],
    //        $result['statusCode'],
    //        $result['headers']
    //     );
    // }

    // /**
    //  * @param JsonResource $resource
    //  * @param null|string $message
    //  * @param int $statusCode
    //  * @param array $headers
    //  * @return JsonResponse
    //  */
    // protected function respondWithResource(JsonResource $resource, $message = null, $statusCode = 200, $headers = []):JsonResponse
    // {
    //     return $this->apiResponse(
    //         [
    //             'success' => true,
    //             'message' => $message,
    //             'data' => $resource,
    //         ], $statusCode, $headers
    //     );
    // }

    // /**
    //  * @param ResourceCollection $resourceCollection
    //  * @param null $message
    //  * @param int $statusCode
    //  * @param array $headers
    //  * @return JsonResponse
    //  */
    // protected function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, $statusCode = 200, $headers = [])
    // {
    //     return $this->apiResponse(
    //         [
    //             'success' => true,
    //             'data' => $resourceCollection->response()->getData()
    //         ], $statusCode, $headers
    //     );
    // }

    // /**
    //  * Respond with success.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondSuccess($message = '')
    // {
    //     return $this->apiResponse(['success' => true, 'message' => $message]);
    // }

    // /**
    //  * Respond with created.
    //  *
    //  * @param $data
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondCreated($data)
    // {
    //     return $this->apiResponse($data, 201);
    // }

    // /**
    //  * Respond with no content.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondNoContent($message = 'No Content Found')
    // {
    //     return $this->apiResponse(['success' => false, 'message' => $message], 200);
    // }

    // /**
    //  * Respond with no content.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondNoContentResource($message = 'No Content Found')
    // {
    //     return $this->respondWithResource(new EmptyResource([]), $message);
    // }
    // /**
    //  * Respond with no content.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondNoContentResourceCollection($message = 'No Content Found')
    // {
    //     return $this->respondWithResourceCollection(new EmptyResourceCollection([]), $message);
    // }

    // /**
    //  * Respond with unauthorized.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondUnAuthorized($message = 'Unauthorized')
    // {
    //     return $this->respondError($message, 401);
    // }

    // /**
    //  * Respond with error.
    //  *
    //  * @param $message
    //  * @param int $statusCode
    //  *
    //  * @param Exception|null $exception
    //  * @param bool|null $error_code
    //  * @return JsonResponse
    //  */
    // protected function respondError($message, int $statusCode = 400, Exception $exception = null, int $error_code = 1)
    // {
    //     return $this->apiResponse(
    //         [
    //             'success' => false,
    //             'message' => $message ?? 'There was an internal error, Pls try again later',
    //             'exception' => $exception,
    //             'error_code' => $error_code
    //         ], $statusCode
    //     );
    // }

    // /**
    //  * Respond with forbidden.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondForbidden($message = 'Forbidden')
    // {
    //     return $this->respondError($message, 403);
    // }

    // /**
    //  * Respond with not found.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondNotFound($message = 'Not Found')
    // {
    //     return $this->respondError($message, 404);
    // }

    // /**
    //  * Respond with internal error.
    //  *
    //  * @param string $message
    //  *
    //  * @return JsonResponse
    //  */
    // protected function respondInternalError($message = 'Internal Error')
    // {
    //     return $this->respondError($message, 500);
    // }

    // protected function respondValidationErrors(ValidationException $exception)
    // {
    //     return $this->apiResponse(
    //         [
    //             'success' => false,
    //             'message' => $exception->getMessage(),
    //             'errors' => $exception->errors()
    //         ],
    //         422
    //     );
    // }



    /**
     * PEMBATAS
     */

   
    /**
     * Success Format Response API
     * 
     * name    [message]
     * success [boolean]
     * message [string]
     * data    [object]
     * 
     */

    /**
     * Failed Format Response API
     * 
     * success [boolean]
     * message [string]
     * error_code [int]
     * 
     */


    /**
     * @param JsonResource $resource
     * @param null|string $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResource(JsonResource $resource, string $name = null , string $message = null, int $statusCode = 200, array $headers = []):JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'name' => $name,
                'message' => $message,
                'result' => $resource->response()->getData(),
            ], $statusCode, $headers
        );
    }

    /**
     * @param ResourceCollection $resourceCollection
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function responseWithResourceCollection(ResourceCollection $resourceCollection,string $name= null, string $message = null, $statusCode = 200, $headers = [])
    {
        return $this->apiResponse(
            [
                'name' => $name,
                'message' => $message,
                'success' => true,
                'result' => $resourceCollection->response()->getData()
            ], $statusCode, $headers
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
    protected function apiResponse($data = [], $statusCode = 200, $headers = []):JsonResponse
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
    public function parseGivenData(array $data = [],int $statusCode = 200, array $headers = []):array
    {
        $responseStructure = [
            'success' => $data['success'],
            'name' => $data['name']??null,
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null,
        ];

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
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
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }

        /** when response failed */
        if ($data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }
        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }
    
}

?>
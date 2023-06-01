<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function Response($message,$status,$data = null): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'data' => $data ?? 'empty data'
            ],
            $status
        );
    }

    public function SuccessResponse($message = null): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'Success',
                'Success' => true
            ],
            200
        );
    }

    public function failureResponse($message = null,$status = 205): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'failure',
                'Success' => false
            ],
            $status
        );
    }

    public function CreatedResponse($message = null,$status = 200): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'Data created successfully',
                'Created' => true
            ],
            $status
        );
    }

    public function UpdatedResponse($message = null,$status = 200): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'Data Updated successfully',
                'Updated' => true
            ],
            $status
        );
    }

    public function DeletedResponse($message = null,$status = 200): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'Data Deleted successfully',
                'Deleted' => true
            ],
            $status
        );
    }

    public function DataResponse($data,$message = null,$status = 200): JsonResponse
    {
        return response()->json(
            [
                'message' => $message ?? 'Success',
                'Success' => true,
                'data' => $data
            ],
            $status
        );
    }
}

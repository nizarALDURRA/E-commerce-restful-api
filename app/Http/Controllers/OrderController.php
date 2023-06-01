<?php

namespace App\Http\Controllers;

use App\Action\PaymentAction;
use App\Service\OrderService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponseTrait;
    public function Order(OrderService $orderService,PaymentAction $paymentAction): JsonResponse
    {
        try {
                $user_id = auth()->user()->id;
                 $orderService->execute($user_id);
                $paymentAction->initialize()->pay($user_id,$orderService->GetTotalPrice());
                return $this->SuccessResponse();
        }catch (\Exception $exception){
            return $this->failureResponse($exception->getMessage());
        }
    }
}

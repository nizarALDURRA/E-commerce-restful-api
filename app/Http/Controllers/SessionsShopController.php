<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\EditCartRequest;
use App\Models\Cart_item;
use App\Service\CartService;
use App\Service\SessionsService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class SessionsShopController extends Controller
{
    use ApiResponseTrait;
    protected SessionsService $sessionsService;
    protected CartService $cartService;

    public function __construct(SessionsService $sessionsService , CartService $cartService)
    {
        $this->sessionsService = $sessionsService;
        $this->cartService = $cartService;
    }

    public function addItems(AddCartRequest $request): JsonResponse
    {
        $user = auth()->user();
        $Sessions = $this->sessionsService->CreateSessions($user);
        return $this->cartService->AddCartItem($Sessions,$request->product_id,$request->quantity)
            ? $this->SuccessResponse('Successfully Add item')
            : $this->failureResponse();
    }

    public function ReduceItems(EditCartRequest $request): JsonResponse
    {
        return $this->cartService->ReduceCartItem($request->cart_id,$request->quantity)
        ? $this->SuccessResponse('Successfully Remove items')
        : $this->failureResponse();
    }

    public function GetItems(): JsonResponse
    {
        $itemsWithProduct = Cart_item::with('product')
            ->where('session_id',auth()->user()->session->id)
            ->get();
        return $this->DataResponse($itemsWithProduct);
    }

    public function GetSession(): JsonResponse
    {
        return $this->DataResponse(
            $this->sessionsService->CreateSessions(auth()->user())
        );
    }
}

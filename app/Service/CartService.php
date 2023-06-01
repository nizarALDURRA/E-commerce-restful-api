<?php


namespace App\Service;


use App\Models\Cart_item;
use App\Models\Product;
use App\Models\Shopping_session;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function RemoveCartItemm($cart_id,$quantity):bool
    {
        $cart = Cart_item::findOrFail($cart_id);
        if( $cart->quantity > $quantity ) {

            $product = Product::findOrFail( $cart->product_id );
            $product->inventory += $quantity;
            $product->save();

            $cart->quantity -= $quantity;
            $cart->save();
        }
    }

    public function AddCartItem(Shopping_session $session,int $product_id,int $quantity):bool
    {
        if(
            $this->productService
            ->SetProduct($product_id)
            ->SetQuantity($quantity)
            ->checkInventory()
        ){
            DB::transaction(function () use ($quantity, $session) {
                $total = $this->productService
                    ->ReduceInventory()
                    ->save()
                    ->CalculateTotalPrice();
                $session->total += $total;
                $session->save();
                $session->items()->create([
                    'product_id' => $this->productService->GetProduct()->id,
                    'quantity' => $quantity
                ]);
            });

            return true;
        }
        return false;

    }

    public function ReduceCartItem(int $cart_id,int $quantity):bool
    {
        $cart = Cart_item::findOrFail($cart_id);
        if($cart->quantity > $quantity){
            DB::transaction(function () use ($cart, $quantity) {

                $total = $this->productService
                    ->SetProduct($cart->product_id)
                    ->SetQuantity($quantity)
                    ->IncreaseInventory()
                    ->save()
                    ->CalculateTotalPrice();
                $session = $cart->session;
                $session->total -= $total;
                $session->save();
                $cart->quantity -= $quantity;
                $cart->save();

            });

            return true;
        }
        if($cart->quantity == $quantity){
            DB::transaction(function () use ($cart, $quantity) {
                $total = $this->productService
                    ->SetProduct($cart->product_id)
                    ->SetQuantity($quantity)
                    ->IncreaseInventory()
                    ->save()
                    ->CalculateTotalPrice();
                $session = $cart->session;
                $session->total -= $total;
                $session->save();
                $cart->delete();
            });

            return true;
        }
        return false;

    }
}

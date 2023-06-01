<?php


namespace App\Service;


use App\Models\Product;

class ProductService
{
    protected Product $product;
    protected int $quantity;
    public function GetProduct(): Product
    {
        return $this->product;
    }
    public function SetProduct($id): static
    {
        $this->product =  Product::findOrFail($id);
        return $this;
    }
    public function SetQuantity($quantity): static
    {
        $this->quantity =  $quantity;
        return $this;
    }
    public function SetAll($id,$quantity): static
    {
        $this->product =  Product::findOrFail($id);
        $this->quantity =  $quantity;
        return $this;
    }
    public function checkInventory():bool
    {
       return $this->product->inventory >= $this->quantity;
    }
    public function ReduceInventory(): static
    {
         $this->product->inventory -= $this->quantity;
         return $this;
    }
    public function IncreaseInventory(): static
    {
        $this->product->inventory += $this->quantity;
        return $this;
    }
    public function save(): static
    {
        $this->product->save();
        return $this;
    }
    public function CalculateTotalPrice(): float|int
    {
        return $this->product->price * $this->quantity;
    }
}

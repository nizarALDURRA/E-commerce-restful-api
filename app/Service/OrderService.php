<?php


namespace App\Service;


use App\Models\Order_details;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class OrderService
{
    protected Order_details $order;

    /**
     * @param Order_details $order
     */
    public function setOrder(Order_details $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Order_details
     */
    public function getOrder(): Order_details
    {
        return $this->order;
    }

    public function execute($user_id)
    {
        $user = User::findOrFail($user_id);
        $session = $user->session;
        if($session){
            DB::transaction(function () use ($user_id,$session) {
                $this->CreateOrder($user_id,$session->total);
                $CartItem = $session
                    ->items()
                    ->get(['product_id','quantity'])
                    ->toArray();
                $this->CreateItems($CartItem);
                $session->delete();
            });
            return;
        }
        throw new \Exception('not have any order ',500);
    }

    protected function CreateOrder($user_id,$total)
    {
        $order = new Order_details();
        $order->user_id = $user_id;
        $order->total = $total;
        $order->save();
        $this->setOrder($order);
    }

    protected function CreateItems($data)
    {
        $this->order->items()->createMany($data);
    }

    public function GetTotalPrice()
    {
        return $this->order->total;
    }
}

<?php

namespace App\Services;

use App\Traits\TransactionFunction;
use App\Models\Order;

class OrderService
{
    use TransactionFunction;
    public function checkOut()
    {
        $carts = session('cart');
        $user = auth()->user();
        $createOrder = function () use ($carts, $user) {
            $order = new Order();
            $order['user_id'] = $user->id;
            $order['total'] = 0;
            $order->save();
            foreach ($carts as $key => $cart) {
                $order->orderDetails()->create([
                    'order_id' => $order->id,
                    'product_id' => $key,
                    'price' => $cart['price'],
                    'quantity' => $cart['quantity'],
                ]);
            }
        };
        session()->flush();
        $this->transactionExecWihReq($createOrder);
    }
}

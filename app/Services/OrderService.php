<?php

namespace App\Services;

use App\Traits\TransactionFunction;
use App\Models\Order;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderService
{
    private $shopId = 84875;
    private $shopDistrict = 1882;
    private $shopWardCode = "330702";
    use TransactionFunction;
    public function checkOut(Request $req)
    {
        $ghn_order_id = $this->createGHNOrder($req);
        if (isset($ghn_order_id["code"]) && $ghn_order_id["code"] == 400) {
            return response()->json(["msg" => $ghn_order_id["code_message_value"]], 400);
        }
        $orderCode = $ghn_order_id["order_code"];
        $carts = session('cart');
        $user = auth()->user();
        $createOrder = function () use ($carts, $user, $orderCode) {
            $order = new Order();
            $order['user_id'] = $user->id;
            $order['total'] = 0;
            $order['order_code'] = $orderCode;
            $order->save();
            foreach ($carts as $key => $cart) {
                $order->orderDetails()->create([
                    'order_id' => $order->id,
                    'product_id' => $key,
                    'price' => $cart['price'],
                    'quantity' => $cart['quantity'],
                ]);
            }
            session()->forget('cart');
        };
        $this->transactionExecWihReq($createOrder);
        return response()->json(["msg" => $ghn_order_id["order_code"]], 200);
    }
    public function prepareOrder()
    {
        $carts = session('cart');
        $order = [];
        foreach ($carts as $key => $cart) {
            $product = Product::find($key);
            $detail = [
                'name' => $product->name,
                'product_id' => $key,
                'price' => (int)$cart['price'],
                'quantity' => (int)$cart['quantity'],
            ];
            array_push($order, $detail);
        }
        return $order;
    }
    public function total(array $order)
    {
        return array_reduce($order, fn ($carry, $item) => $carry + $item['quantity'] * $item['price'], 0);
    }
    public function createGHNOrder(Request $req)
    {
        try {
            $order = $this->prepareOrder();
            $insurance_value = $this->total($order);
            $phone = $req->user_phone == "null" ? "0901952110" : $req->user_phone;
            $shift = DeliveryService::getShiftDate();
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b',
                "ShopId" => $this->shopId,
            ])
                ->post('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create', [
                    "payment_type_id" => 2,
                    "note" => "$req->ship_msg",
                    "required_note" => "KHONGCHOXEMHANG",
                    "return_phone" => "0901952110",
                    "return_address" => "39 NTT",
                    "return_district_id" => null,
                    "return_ward_code" => "",
                    "client_order_code" => "",
                    "to_name" => "$req->user_name",
                    "to_phone" => "$phone",
                    "to_address" => "$req->address",
                    "to_ward_code" => $req->ward_code,
                    "to_district_id" => $req->district_id,
                    "cod_amount" => $insurance_value,
                    "content" => "",
                    "weight" => 200,
                    "length" => 1,
                    "width" => 19,
                    "height" => 10,
                    "pick_station_id" => 1444,
                    "insurance_value" => $insurance_value,
                    "service_id" => (int)$req->ship_service_id,
                    "service_type_id" => 0,
                    "coupon" => null,
                    "pick_shift" => [
                        $shift["id"]
                    ],
                    "items" => $order

                ]);
            $resp = $response->collect();
            if ($resp["code"] == 400) {
                return $resp;
            }
            $data = $response
                ->collect("data");
            return ($data->toArray());
        } catch (\Throwable $th) {
            return [];
        }
    }
}

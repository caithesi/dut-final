<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Services\DeliveryService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;


class DeliveryController extends Controller
{
    private $token = 'd3467951-8c6c-11ec-ac64-422c37c6de1b';
    private $shopId = 84875;
    private $shopDistrict = 1882;
    private $shopWardCode = "330702";

    private $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    public function shipping()
    {
        return View::shopper('shopper.product.shipping');
    }
    public function getProvince()
    {
        $response = Http::withHeaders([
            'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b'
        ])
            ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province')
            ->collect('data')
            ->filter(fn ($var) => $var["Status"] == 1)
            ->map(fn ($var) => [
                "ProvinceID" => $var["ProvinceID"],
                "ProvinceName" => $var["ProvinceName"]
            ]);
        return ($response->toArray());
    }
    public function getDistrict($province_id)
    {
        try {
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b'
            ])
                ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district', [
                    "province_id" => $province_id
                ])
                ->collect('data')
                ->filter(fn ($var) => $var["Status"] == 1)
                ->map(fn ($var) => [
                    "DistrictID" => $var["DistrictID"],
                    "DistrictName" => $var["DistrictName"],
                    "Code" => $var["Code"]
                ]);

            return $response->toArray();
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getWard($district_id)
    {
        try {
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b'
            ])
                ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward', [
                    "district_id" => $district_id
                ])
                ->collect("data")
                ->filter(function ($value, $key) {
                    return $value["Status"] == 1;
                })
                ->map(fn ($var) => [
                    "WardCode" => $var["WardCode"],
                    "WardName" => $var["WardName"]
                ]);
            return ($response->toArray());
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getFee($district_id, $ward_code, $service_id)
    {
        try {
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b',
            ])
                ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee', [
                    "service_id" => $service_id,
                    "insurance_value" => 50000,
                    "coupon" => null,
                    "from_district_id" => 1882,
                    "to_district_id" => $district_id,
                    "to_ward_code" => "$ward_code",
                    "height" => 15,
                    "length" => 15,
                    "weight" => 1000,
                    "width" => 15
                ])
                ->collect('data');
            return (($response->toArray()["total"]));
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function getAvailableService($district_id)
    {
        try {
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b'
            ])
                ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/available-services', [
                    "shop_id" => $this->shopId,
                    "from_district" => $this->shopDistrict,
                    "to_district" => $district_id
                ])
                ->collect('data')
                ->filter(fn ($value, $key) => $value["short_name"] != "");
            return ($response->toArray());
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function preview(Request $req)
    {
        try {
            $order = $this->orderService->prepareOrder();
            $insurance_value = $this->orderService->total($order);
            $phone = $req->user_phone == "null" ? "0901952110" : $req->user_phone;
            $shift = DeliveryService::getShiftDate();
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b',
                "ShopId" => $this->shopId,
            ])
                ->post('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/preview', [
                    "payment_type_id" => 2,
                    "note" => "$req->ship_msg",
                    "required_note" => "KHONGCHOXEMHANG",
                    "return_phone" => "0332190444",
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
            $test = $response->collect();
            $data = $response
                ->collect("data")
                ->filter(fn ($value, $key) => $key ==  "total_fee" || $key == "expected_delivery_time");
            return ($data->toArray());
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function leadTime(Request $req)
    {
        try {
            $response = Http::withHeaders([
                'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b',
                "shop_id" => $this->shopId,
            ])
                ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/leadtime', [

                    "from_district" => $this->shopDistrict,
                    "from_ward_code" => $this->shopWardCode,
                    "to_district_id" => $req->district_id,
                    "to_ward_code" => $req->ward_code,
                    "service_id" => $req->service_id
                ])
                ->collect('data');
            return ($response->toArray());
        } catch (\Throwable $th) {
            return [];
        }
    }
}

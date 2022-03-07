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
    private $deliveryService;
    private $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->deliveryService = new DeliveryService();
    }
    public function shipping()
    {
        return View::shopper('shopper.product.shipping');
    }
    public function getProvince()
    {
        return ($this->deliveryService->getProvince());
    }
    public function getDistrict($province_id)
    {
        return $this->deliveryService->getDistrict($province_id);
    }
    public function getWard($district_id)
    {
        return $this->deliveryService->getWard($district_id);
    }
    public function getFee($district_id, $ward_code, $service_id)
    {
        return $this->deliveryService->getFee($district_id, $ward_code, $service_id);
    }
    public function getAvailableService($district_id)
    {
        return $this->deliveryService->getAvailableService($district_id);
    }
    public function preview(Request $req)
    {
        return $this->deliveryService->preview($req);
    }
    public function leadTime(Request $req)
    {
        return $this->deliveryService->leadTime($req);
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

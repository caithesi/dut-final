<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    public function checkOut()
    {
        $this->orderService->checkOut();
    }
}

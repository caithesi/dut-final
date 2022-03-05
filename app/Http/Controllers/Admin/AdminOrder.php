<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrder extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $viewDir;
    private $viewFiles;
    public function __construct()
    {
        $this->viewDir = 'pages.orders';
        $this->viewFiles = [
            'index' => $this->viewDir . '.index',
            'detail' => $this->viewDir . '.detail',
        ];
    }
    public function index()
    {
        $orders = Order::with(['customer' => function ($q) {
            $q->select('id', 'name');
        }])->latest()->paginate(5);
        return View::component($this->viewFiles['index'], compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $detail = $order->orderDetails;
        $detailProduct =
            $detail
            ->map(fn ($var) => $var->product)
            ->keyBy('id')
            ->map(function ($var) {
                return $var['name'];
            })
            ->toArray();
        return View::component($this->viewFiles['detail'], compact('detail', 'detailProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

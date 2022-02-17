<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rate;
use App\Services\ProductService;
use App\Types\Functional;
use App\Types\MultiFunctional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use stdClass;

class ShopperProductController extends Controller
{
    private $viewDir;
    private $viewFiles;
    private $productService;
    public function __construct()
    {
        $this->viewDir = 'shopper.product';
        $this->viewFiles = [
            'index' => $this->viewDir . '.home',
            'add' => $this->viewDir . '.add',
            'edit' => $this->viewDir . '.edit',
            'show' =>  $this->viewDir . '.detail',
            'cart' =>  $this->viewDir . '.cart',
        ];
        $this->productService = new ProductService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $categories = Category::where('parent_id', 0)->with('categoriesChildren')->get();
        $product_img = $product->productImages;
        $userRate = Rate::where('user_id',  auth()->user()->id)->where('product_id', $product->id)->first();
        $rate = isset($userRate) ? $userRate->rating : 0;
        $all_rate = Rate::where('product_id', $product->id)->get('rating')->toArray();
        return View::shopper(
            $this->viewFiles['show'],
            compact('categories', 'product', 'product_img', 'rate', 'all_rate')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    public function addToCart($id)
    {
        $quantity = request('quantity');
        $cart = session()->get('cart');
        $product = Product::find($id);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->feature_img_path,
            ];
        }
        if ($cart[$id]['quantity'] == 0) {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        if (isset($cart[$id])) {
            return response()->json([$cart[$id]], 200);
        }
        return response()->json([], 200);
    }
    public function cartShow()
    {
        $cart = session()->get('cart');
        if ($cart == null) {
            $cart = new stdClass();
        }
        return View::shopper(
            $this->viewFiles['cart'],
            compact('cart')
        );
    }

    public function rating(Request $req, $id)
    {
        return $this->productService->rating($id, $req);
    }
}

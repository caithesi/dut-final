<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Traits\StorageImageTraits;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use StorageImageTraits;
    protected $productService;
    private $viewDir;
    private $viewFiles;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->viewDir = 'pages.product';
        $this->viewFiles = [
            'index' => $this->viewDir . '.index',
            'add' => $this->viewDir . '.add',
            'edit' => $this->viewDir . '.edit',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->select("id", "name", "price", "feature_img_path", "category_id")
            ->latest()
            ->paginate(5);
        return View::component($this->viewFiles['index'], compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select("id", "name", "parent_id")->get();
        return View::component($this->viewFiles['add'], compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $this->productService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::select("id", "name", "parent_id")->get();
        $productImgs = $product->productImages('image_path')->get();
        $product = $product->only('id', 'name', 'category_id', 'price', 'feature_img_path');
        return View::component($this->viewFiles['edit'], compact('product', 'categories', 'productImgs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($request,  $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}

<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShopperCategoryController extends Controller
{
    private $viewDir;
    private $viewFiles;
    private $productCategoryDir;
    private $productCategoryFile;
    public function __construct()
    {
        $this->viewDir = 'shopper.product';
        $this->viewFiles = [
            'index' => $this->viewDir . '.home',
            'add' => $this->viewDir . '.add',
            'edit' => $this->viewDir . '.edit',
        ];
        $this->productCategoryDir = 'shopper.product.category';
        $this->productCategoryFile = [
            'index' => $this->productCategoryDir . '.index',
            'add' => $this->productCategoryDir . '.add',
            'edit' => $this->productCategoryDir . '.edit',
        ];
    }
    public function index($slug, $id)
    {
        // dd(Category::find($id));
        $categories = Category::where('parent_id', 0)->with('categoriesChildren')->get();
        $products = Product::where('category_id', $id)->paginate(8);
        // dd($products);
        return View::shopper(
            $this->productCategoryFile['index'],
            compact('categories', 'products')
        );
    }
}

<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use stdClass;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    private $viewDir;
    private $viewFiles;


    public function __construct()
    {
        $this->viewDir = 'shopper.home';
        $this->viewFiles = [
            'index' => $this->viewDir . '.home',
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
        $sliders = Slider::latest('id', 'name', 'image_path', 'description')->take(5)->get();
        $categories = Category::where('parent_id', 0)->with('categoriesChildren')->get();
        $feature_products = Product::latest()->take(6)->get();
        $category_products = Category::where('parent_id', 0)->with('products')->get();
        $settings = Setting::get();
        $user = auth()->user();
        if ($user == null) {
            $user = new stdClass();
        }
        // dd($user);
        return View::shopper(
            $this->viewFiles['index'],
            compact('sliders', 'categories', 'feature_products', 'category_products', 'user')
        );
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getConfig($config_key)
    {
        $setting = Setting::where('config_key', $config_key)->first();
        if (!empty($setting)) {
            return $setting->config_value;
        }
        return null;
    }
}

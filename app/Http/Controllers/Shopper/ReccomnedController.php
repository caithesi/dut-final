<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Services\RecommendService;

class ReccomnedController extends Controller
{
    private $recService;
    public function __construct()
    {
        $this->recService = new RecommendService();
    }
    public function recommend()
    {
        if (auth()->check()) {
            $user_id = auth()->user()->id;
            return ($this->recService->getRecommendProductForLoggedUser($user_id));
        } else {
            return (Product::orderBy('avg_rate', 'desc')->limit(4)->get());
        }
    }
}

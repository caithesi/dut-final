<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\StorageImageTraits;
use App\Models\Product;
use App\Models\Rate;
use App\Types\Functional;
use App\Types\MultiFunctional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    use StorageImageTraits;

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'products');
            $dataCreateProduct = [
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'user_id' => auth()->id(),
                'content' => '',
            ];
            if ($dataUploadFeatureImage != null) {
                $dataCreateProduct['feature_img_path'] = $dataUploadFeatureImage['file_path'];
                $dataCreateProduct['feature_image_name'] = $dataUploadFeatureImage['file_origin'];
            }
            $newProduct = Product::create($dataCreateProduct);
            $this->storeProductImg($request, $newProduct);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function storeProductImg(Request $request, Product $newProduct)
    {
        if (!$request->hasFile('product_img')) {
            return;
        }
        foreach ($request->product_img as $file) {
            $productImgDetail = $this->storageTraitUploadMultiple($file, 'product');
            $newProduct->productImages()->create([
                'image_path' => $productImgDetail['file_path'],
                'image_name' => $productImgDetail['file_origin']
            ]);
        }
    }

    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'products');
            $dataUpdateProduct = [
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'user_id' => auth()->id(),
                'content' => '',
            ];
            if ($dataUploadFeatureImage != null) {
                $dataUpdateProduct['feature_img_path'] = $dataUploadFeatureImage['file_path'];
                $dataUpdateProduct['feature_image_name'] = $dataUploadFeatureImage['file_origin'];
            }
            $product->update($dataUpdateProduct);
            $product->productImages->delete();
            // $this->storeProductImg($request, $product);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
        }
    }

    public function rating($productId, Request $req)
    {
        $rate = new MultiFunctional(function ($name, $user_id) use ($req, $productId) {
            $old = Rate::where('user_id',  auth()->user()->id)->where('product_id', $productId)->first();
            if (!empty($old)) {
                $old['rating'] = $req->$name;
                $this->updateAvgRate($productId, $old['rating'], false);
                return $old;
            }
            $new_rate = new Rate();
            $new_rate['user_id'] = $user_id;
            $new_rate['product_id'] = $productId;
            $new_rate['rating'] = $req->$name;
            $this->updateAvgRate($productId, $new_rate['rating']);
            return $new_rate;
        });

        $save_rate = new Functional(function (Rate $rate) {
            if ($rate->save()) {
                return $rate;
            }
            return false;
        });

        $create_resp = new Functional(function ($rate) use ($req) {
            if ($req->wantsJson()) {
                if ($rate != false) {
                    return response()->json($rate);
                };
            }
        });


        return $rate->andThen($save_rate)
            ->andThen($create_resp)
            ->apply('rating', auth()->user()->id);
    }
    private function updateAvgRate($productId, $rate, $isNewRate = true)
    {
        $product = Product::find($productId);
        if ($isNewRate) {
            $oldAvg =  $product['avg_rate'];
            $oldTotal = $product['total_rate'];
            $product['avg_rate'] = $oldAvg * $oldTotal / ($oldTotal + 1) + $rate / ($oldTotal + 1);
            $product['total_rate']++;
            $product->save();
            return;
        }
        $deviantRate = $product['avg_rate'] - $rate;
        $product['avg_rate'] = $product['avg_rate'] + $deviantRate / $product['total_rate'];
        $product->save();
        return;
    }
}

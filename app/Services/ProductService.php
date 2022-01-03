<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\StorageImageTraits;
use App\Models\Product;
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

    // public function
}

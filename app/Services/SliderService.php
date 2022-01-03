<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\StorageImageTraits;
use App\Models\Slider;
use App\Traits\TransactionFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SliderService
{
    use StorageImageTraits, TransactionFunction;

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'slider_image', 'sliders');

            $dataInsert = [
                'name' => $request->name,
                'description' => $request->description,
            ];
            if ($dataUploadFeatureImage != null) {
                $dataInsert['image_path'] = $dataUploadFeatureImage['file_path'];
                $dataInsert['image_name'] = $dataUploadFeatureImage['file_origin'];
            }
            $newProduct = Slider::create($dataInsert);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
        }
    }
}

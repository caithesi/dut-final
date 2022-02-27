<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeliveryService
{
    public static function getShiftDate()
    {
        $response = Http::withHeaders([
            'token' => 'd3467951-8c6c-11ec-ac64-422c37c6de1b'
        ])
            ->get('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shift/date')
            ->collect('data')
            ->map(fn ($var) => [
                "id" => $var["id"],
            ]);
        return ($response->toArray()[0]);
    }
}

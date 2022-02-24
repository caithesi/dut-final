<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Rate;

class RecommendService
{
    public $otherNormalize;
    public function __construct()
    {
        $this->otherNormalize = [];
    }
    public function getUserRating($userId)
    {
        return Rate::where('user_id', $userId)->get(['product_id', 'rating'])
            ->mapWithKeys(fn ($rate) => [
                $rate->product_id => $rate->rating
            ]);
    }
    public function getOtherRate($userId)
    {
        return  Rate::where('user_id', '<>', $userId)
            ->get(['user_id', 'product_id', 'rating'])
            ->mapToGroups(
                function ($item, $key) {
                    $key =  $item['user_id'];
                    $value = collect(['product' => $item['product_id'], 'rate' => $item['rating']]);
                    return [
                        $key
                        => $value
                    ];
                }
            )
            ->map(
                fn ($item) =>
                $item->mapWithKeys(fn ($item) => [
                    $item['product'] =>  $item['rate']
                ])
            );
    }
    public function meanUserRating($userRate)
    {
        return array_sum($userRate) / sizeof($userRate);
    }
    public function normalizeUserRating($rate)
    {
        $result = [];
        $mean = $this->meanUserRating($rate);
        foreach ($rate as $item => $rating) {
            $result[$item] = $rating - $mean;
        }
        return $result;
    }

    public function length($normallizeRate)
    {
        return array_reduce($normallizeRate, fn ($carry, $item) => $carry + $item * $item, 0);
    }
    public function similarityBetween2User($userNormallizeRate, $userRateLen, $otherNormallizeRate)
    {
        $tmp = 0;
        foreach ($userNormallizeRate as $pruduct => $rate) {
            if (!isset($otherNormallizeRate[$pruduct])) {
                continue;
            }
            $tmp += $rate *  $otherNormallizeRate[$pruduct];
        }
        $otherLen = $this->length($otherNormallizeRate);
        return $tmp / ($userRateLen + $otherLen);
    }
    public function similarity($userNormallizeRate, $userRateLen, $allOtherRate)
    {
        $result = [];
        foreach ($allOtherRate as $user => $user_rate) {
            $otherNormallizeRate = $this->normalizeUserRating($user_rate);
            $this->otherNormalize[$user] = $otherNormallizeRate;

            $sim = $this->similarityBetween2User($userNormallizeRate, $userRateLen, $otherNormallizeRate);
            $result[$user] = $sim;
        }
        return $result;
    }
    public function nearestUser($similarity, $user_number = 3)
    {
        $result = $similarity;
        arsort($result);
        return array_slice($result, 0, $user_number, true);
    }
    public function nearestProduct($nearestUser = [])
    {
        return array_filter(
            $this->otherNormalize,
            fn ($key) => in_array($key, array_keys($nearestUser)),
            ARRAY_FILTER_USE_KEY
        );
    }
    public function predicateRating($nearestUser = [], $otherNormallizeRate, $user_rate)
    {
        $toDiv = array_reduce($nearestUser, fn ($c, $i) => $c + $i, 0);
        $rec = [];
        foreach ($otherNormallizeRate as $pro_user => $rate_user) {
            foreach ($rate_user as $p => $r) {
                if (isset($user_rate[$p])) {
                    continue;
                }

                if (!isset($rec[$p])) {
                    $rec[$p] = 0;
                }
                $rec[$p] += $r * $nearestUser[$pro_user];
            }
        }

        return array_map(function ($var) use ($toDiv) {
            return $var / $toDiv;
        }, $rec);
    }
    public function getRecommendProductForLoggedUser($user_id, $quantity = 4)
    {
        $resul = [];
        try {
            $user_rate = $this->getUserRating($user_id)->toArray();
            $userNormalizeRating = $this->normalizeUserRating($user_rate);
            $lenUserRate = $this->length($userNormalizeRating);
            $other = $this->getOtherRate($user_id)->toArray();

            $similarity = $this->similarity($userNormalizeRating, $lenUserRate, $other);
            $nearestUser = $this->nearestUser($similarity);

            $product = $this->nearestProduct($nearestUser);
            $tmp_result = $this->predicateRating($nearestUser, $product, $user_rate);
            arsort($tmp_result);
            $tmp_result = array_keys($tmp_result);
            $count = $quantity;
            while ((sizeof($resul) < $quantity) && $count <= sizeof($tmp_result)) {
                $nearestProduct = (array_slice($tmp_result, 0, $count, true));
                $resul = Product::findMany($nearestProduct)->toArray();
                $count++;
            }
            $size = sizeof($resul);
            $lack = $quantity - $size;
            if ($lack > 0) {
                $bonus = Product::whereNotIn('id', $tmp_result)
                    ->orderBy('avg_rate', 'desc')
                    ->limit($lack)->get()->toArray();
                $resul = array_merge($resul, $bonus);
            };
        } catch (\Throwable $th) {
            $resul = Product::orderBy('avg_rate', 'desc')->limit($quantity)->get();
        }
        return $resul;
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPUnit\Framework\isEmpty;

class RateFactory extends Factory
{
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1, User::count());
        $product_id = $this->faker->numberBetween(1, Product::count());
        $rate = Rate::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        while (!empty($rate)) {
            $user_id = $this->faker->numberBetween(1, User::count());
            $product_id = $this->faker->numberBetween(1, Product::count());
            $rate = Rate::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        }
        return [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}

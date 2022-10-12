<?php

namespace App\Packages\Samples\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SampleFactory extends Factory
{
    protected $model = \App\Packages\Samples\Models\Sample::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'number' => fake()->randomNumber(1000, 5000),
            'email' => fake()->safeEmail(),
            'description' => fake()->region(),
            'location' => fake()->region(),
        ];
    }
}

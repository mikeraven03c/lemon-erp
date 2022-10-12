<?php

namespace App\Packages\VirtualAttributes\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VirtualAttributeFactory extends Factory
{
    protected $model = \App\Packages\VirtualAttributes\Models\VirtualAttribute::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'field' => fake()->region(),
            'type' => fake()->region(),
            'is_required' => fake()->boolean(),
            'tab' => fake()->region(),
            'is_choices' => fake()->boolean(),
        ];
    }
}

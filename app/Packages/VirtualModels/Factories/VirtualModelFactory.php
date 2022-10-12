<?php

namespace App\Packages\VirtualModels\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VirtualModelFactory extends Factory
{
    protected $model = \App\Packages\VirtualModels\Models\VirtualModel::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'table_name' => fake()->region(),
        ];
    }
}

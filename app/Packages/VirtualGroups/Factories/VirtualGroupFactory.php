<?php

namespace App\Packages\VirtualGroups\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VirtualGroupFactory extends Factory
{
    protected $model = \App\Packages\VirtualGroups\Models\VirtualGroup::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'label' => fake()->region(),
            'priority' => fake()->randomNumber(1000, 5000),
        ];
    }
}

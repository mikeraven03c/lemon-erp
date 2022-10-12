<?php

namespace App\Packages\Samples\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\VirtualColumn\VirtualColumn;

class Sample extends Model
{
    use VirtualColumn;

    public $guarded = [];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'number',
            'email',
            'description',
            'location',
        ];
    }

    protected $hidden = [
    ];

    protected static function newFactory()
    {
        return \App\Packages\Samples\Factories\SampleFactory::new();
    }
}

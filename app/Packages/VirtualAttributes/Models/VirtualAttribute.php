<?php

namespace App\Packages\VirtualAttributes\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\VirtualColumn\VirtualColumn;

class VirtualAttribute extends Model
{
    use VirtualColumn;

    public $guarded = [];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'field',
            'type',
            'virtual_model_id',
            'is_required',
            'tab',
            'is_choices',
            'options',
            'updated_at',
            'created_at'
        ];
    }

    protected $hidden = [
    ];

    protected static function newFactory()
    {
        return \App\Packages\VirtualAttributes\Factories\VirtualAttributeFactory::new();
    }
}

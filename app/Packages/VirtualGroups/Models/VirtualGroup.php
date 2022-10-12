<?php

namespace App\Packages\VirtualGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\VirtualColumn\VirtualColumn;

class VirtualGroup extends Model
{
    use VirtualColumn;

    public $guarded = [];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'label',
            'priority',
        ];
    }

    protected $hidden = [
    ];

    protected static function newFactory()
    {
        return \App\Packages\VirtualGroups\Factories\VirtualGroupFactory::new();
    }
}

<?php

namespace App\Packages\VirtualModels\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\VirtualColumn\VirtualColumn;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Packages\VirtualAttributes\Models\VirtualAttribute;

class VirtualModel extends Model
{
    use VirtualColumn;
    use SoftDeletes;

    public $guarded = [];


    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'table_name',
            'endpoint',
            'virtual_group_id',
        ];
    }

    public function attributes()
    {
        return $this->hasMany(VirtualAttribute::class);
    }

    public function scopeEndpoint($query, $endpoint)
    {
        $query->where('endpoint', $endpoint);
    }

    protected $hidden = [
    ];

    protected static function newFactory()
    {
        return \App\Packages\VirtualModels\Factories\VirtualModelFactory::new();
    }
}

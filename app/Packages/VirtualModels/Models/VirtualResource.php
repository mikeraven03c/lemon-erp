<?php

namespace App\Packages\VirtualModels\Models;

use App\Packages\VirtualModels\Traits\VirtualResourceTrait;
use Illuminate\Database\Eloquent\Model;
use Stancl\VirtualColumn\VirtualColumn;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualResource extends Model
{
    use VirtualColumn;
    use VirtualResourceTrait;

    public $guarded = [];

    protected $hidden = [
    ];

    public static function model(VirtualModel $model)
    {
        $vResource = new self;

        $tableName = config('virtual.table.prefix') . $model->table_name;

        $vResource->setTable($tableName);

        return $vResource;
    }
}

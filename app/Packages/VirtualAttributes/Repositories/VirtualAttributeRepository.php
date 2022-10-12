<?php

namespace App\Packages\VirtualAttributes\Repositories;

use App\Lemon\Components\DataTransferObject\SelectSSRData;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualAttributes\Models\VirtualAttribute;
use App\Packages\VirtualAttributes\Contracts\VirtualAttributeContract;
use App\Packages\VirtualAttributes\Requests\VirtualAttributeFormRequest;
use App\Packages\VirtualAttributes\DataTransferObject\VirtualAttributeData;

class VirtualAttributeRepository implements VirtualAttributeContract
{
    public function getAttributeBySelect($virtualModelId)
    {
        $attribute = VirtualAttribute::where('virtual_model_id', $virtualModelId)->get();
        return $attribute->pluck('field');
    }

    public function getAttributeByOrder(VirtualModel $model)
    {
        $attribute = $model->attributes();
        return $attribute->orderBy('data->order', 'asc')->get();
    }

    public function store(VirtualAttributeFormRequest $request) : VirtualAttribute
    {
        $data = VirtualAttributeData::toAttribute($request);
        return VirtualAttribute::create($data->toArray());
    }

    public function update(VirtualAttribute $virtualattribute, VirtualAttributeFormRequest $request) : VirtualAttribute
    {
        $data = VirtualAttributeData::toAttribute($request);
        $virtualattribute->update($data->toArray());
        return $virtualattribute;
    }

    public function delete(array $ids) {
        return VirtualAttribute::destroy($ids);
    }
}

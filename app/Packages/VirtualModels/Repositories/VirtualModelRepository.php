<?php

namespace App\Packages\VirtualModels\Repositories;

use App\Lemon\Components\DataTransferObject\SelectSSRData;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Contracts\VirtualModelContract;
use App\Packages\VirtualModels\DataTransferObject\VirtualModelData;
use App\Packages\VirtualModels\Events\VirtualModelCreatedEvent;
use App\Packages\VirtualModels\Events\VirtualModelDeletedEvent;
use App\Packages\VirtualModels\Requests\VirtualModelFormRequest;

class VirtualModelRepository implements VirtualModelContract
{
    public function getSelectSSR(string $select)
    {
        $data = SelectSSRData::collection(
            VirtualModel::select('id', $select)->get()
        );
        return $data->toArray();
    }

    public function getModelAttribute($modelId)
    {
        $model = VirtualModel::findOrFail($modelId);
        $attributes = $model->attributes;
        return $attributes;
    }

    public function store(VirtualModelFormRequest $request) : VirtualModel
    {
        $dto = VirtualModelData::toDB($request);

        $data =  VirtualModel::create($dto->toArray());

        VirtualModelCreatedEvent::dispatch($data);

        return $data;
    }

    public function update(VirtualModel $virtualmodel, VirtualModelFormRequest $request) : VirtualModel
    {
        $virtualmodel->update($request->toArray());
        return $virtualmodel;
    }

    public function delete(array $ids) {
        $models = VirtualModel::whereIn('id', $ids)->get();
        $destroy = VirtualModel::destroy($ids);

        VirtualModelDeletedEvent::dispatch($models);

        return $destroy;
    }
}

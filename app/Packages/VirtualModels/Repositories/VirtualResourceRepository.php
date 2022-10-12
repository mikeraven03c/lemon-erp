<?php

namespace App\Packages\VirtualModels\Repositories;

use Illuminate\Support\Facades\DB;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Models\VirtualResource;
use App\Packages\VirtualModels\Contracts\VirtualResourceContract;
use App\Packages\VirtualAttributes\Contracts\VirtualAttributeContract;
use Illuminate\Support\Collection;

class VirtualResourceRepository implements VirtualResourceContract
{
    protected VirtualResource $vResource;
    protected VirtualModel $model;
    protected VirtualAttributeContract $vAttribute;
    protected array|Collection $attributes;

    public function __construct(VirtualAttributeContract $vAttribute)
    {
        $this->vAttribute = $vAttribute;
    }

    public function getMenu()
    {
        return VirtualModel::get();
    }

    public function getModelThroughEndpoint($endpoint)
    {
        $this->model = VirtualModel::endpoint($endpoint)->firstOrFail();
        return $this->model;
    }

    public function getReferenceData()
    {
        $data = [];
        foreach ($this->attributes as $attribute) {
            if ($attribute->type == 'reference') {
                $model = VirtualModel::findOrFail($attribute->reference);

                $resource = $this->getVirtualResource($model->table_name);
                $data[$model->id] = $resource->get()->map(function ($item) use ($attribute) {
                    return [
                        'label' => $item[$attribute['field_reference']],
                        'value' => $item['id']
                    ];
                });
            }
        }

        return $data;
    }

    public function getVirtualResource($tableName = '') : VirtualResource
    {
        $vResource = new VirtualResource;


        $tableName = $tableName ? config('virtual.table.prefix') . $tableName : $this->getTableName();

        $vResource->setTable($tableName);

        return $vResource;
    }

    public function getAttributeByOrder()
    {
        $data = $this->vAttribute->getAttributeByOrder($this->model);
        $this->attributes = $data;
        return $data;
    }

    public function create(array $input) : VirtualResource
    {
        $vResource = $this->getVirtualResource();
        return $vResource->create($input);
    }

    public function update($id, array $input) : bool
    {
        $this->vResource = $this->getVirtualResource();
        $this->vResource = $this->vResource->findOrFail($id);
        return $this->vResource->update($input);
    }

    public function getTableName() : string
    {
        return config('virtual.table.prefix') . $this->model->table_name;
    }

    public function getModel() : VirtualResource
    {
        return $this->vResource;
    }

    public function destroy($ids)
    {
        $tableName = $this->getTableName();
        return DB::table($tableName)->delete($ids);
    }
}

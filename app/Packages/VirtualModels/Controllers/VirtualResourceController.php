<?php

namespace App\Packages\VirtualModels\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Models\VirtualResource;
use App\Packages\VirtualModels\Contracts\VirtualModelContract;
use App\Packages\VirtualModels\Resources\VirtualModelResource;
use App\Packages\VirtualModels\Requests\VirtualModelFormRequest;
use App\Packages\VirtualModels\Contracts\VirtualResourceContract;
use App\Packages\VirtualModels\Repository\VirtualModelRepository;
use App\Packages\VirtualModels\Resources\VirtualResourceResource;
use App\Packages\VirtualModels\Resources\VirtualModelMenuResource;
use App\Packages\VirtualAttributes\Contracts\VirtualAttributeContract;
use App\Packages\VirtualAttributes\Resources\VirtualAttributeColumnResource;

class VirtualResourceController
{
    protected VirtualResourceContract $vResource;
    protected VirtualAttributeContract $vAttribute;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        VirtualResourceContract $vResource,
    )
    {
        $this->vResource = $vResource;
    }

    public function getIndexData(Request $request, $endpoint)
    {
        $virtualModel= $this->vResource->getModelThroughEndpoint($endpoint);
        $data = $this->vResource->getVirtualResource()->get();

        $attributes = $this->vResource->getAttributeByOrder();

        $model = new VirtualModelMenuResource($virtualModel);

        $columns = VirtualAttributeColumnResource::collection($attributes);

        $references = $this->vResource->getReferenceData();

        return compact('model', 'data', 'columns', 'references');
    }

    public function getTableData(Request $request, $endpoint)
    {
        $this->vResource->getModelThroughEndpoint($endpoint);

        $data = $this->vResource->getVirtualResource()->get();

        return compact('data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $endpoint)
    {
        try {
            $this->vResource->getModelThroughEndpoint($endpoint);
            $response = $this->vResource->create($request->all());
            return [
                'status' => 1,
                'message' => 'data' . config('message.store.positive'),
                'data' => $response
            ];
        } catch (\Exception $e) {
            return [
                'message' => $request->name . config('message.store.negative'),
                'status' => 0,
                'exception' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new VirtualModelResource(VirtualModel::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $endpoint)
    {
        try {
            $this->vResource->getModelThroughEndpoint($endpoint);
            $response = $this->vResource->update($request->id, $request->all());

            return [
                'status' => $response,
                'message' => 'data' . config('message.update.positive'),
                'data' => $this->vResource->getModel()
            ];
        } catch (\Exception $e) {
            return [
                'message' => $request->name . config('message.update.negative'),
                'status' => 0,
                'exception' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $endpoint)
    {
        $this->vResource->getModelThroughEndpoint($endpoint);
        $status = $this->vResource->destroy($request->all());

        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}

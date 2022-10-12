<?php

namespace App\Packages\VirtualAttributes\Controllers;

use Illuminate\Http\Request;
use App\Packages\VirtualAttributes\Models\VirtualAttribute;
use App\Packages\VirtualAttributes\Contracts\VirtualAttributeContract;
use App\Packages\VirtualAttributes\Resources\VirtualAttributeResource;
use App\Packages\VirtualAttributes\Requests\VirtualAttributeFormRequest;
use App\Packages\VirtualModels\Contracts\VirtualModelContract;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Resources\VirtualModelResource;

class VirtualAttributeController
{
    public function getVModelSelectSSR(
        Request $request,
        $select,
        VirtualModelContract $vModel
    )
    {
        return $vModel->getSelectSSR($select);
    }

    public function getSelectVAttribute(
        Request $request,
        $select,
        VirtualAttributeContract $attribute
    ) {
        return $attribute->getAttributeBySelect($select);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $virtualattribute = VirtualAttribute::latest()->get();
        return VirtualAttributeResource::collection($virtualattribute);
    }

    public function getIndexData(Request $request)
    {
        $virtualattribute = VirtualAttribute::where('virtual_model_id', $request->id)->latest()->get();
        return VirtualAttributeResource::collection($virtualattribute)->additional([
            'model' => new VirtualModelResource(VirtualModel::findOrFail($request->id))
        ]);
    }

    public function getData(Request $request)
    {
        $virtualattribute = VirtualAttribute::where('virtual_model_id', $request->id)->latest()->get();
        return VirtualAttributeResource::collection($virtualattribute);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VirtualAttributeFormRequest $request, VirtualAttributeContract $virtualattributeContract)
    {
        try {
            $virtualattribute = $virtualattributeContract->store($request);
            return (new VirtualAttributeResource($virtualattribute))->additional([
                'status' => 1,
                'message' => $virtualattribute->name . config('message.store.positive')
            ]);
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
        return (new VirtualAttributeResource(VirtualAttribute::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VirtualAttributeFormRequest $request, $id, VirtualAttributeContract $virtualattributeContract)
    {
        try {
            $virtualattribute = VirtualAttribute::findOrFail($id);
            $virtualattribute = $virtualattributeContract->update($virtualattribute, $request);
            return (new VirtualAttributeResource($virtualattribute))->additional([
                'status' => 1,
                'message' => $virtualattribute->name . config('message.update.positive')
            ]);
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
    public function destroy(Request $request, VirtualAttributeContract $virtualattributeContract)
    {
        $status = $virtualattributeContract->delete($request->all());
        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}

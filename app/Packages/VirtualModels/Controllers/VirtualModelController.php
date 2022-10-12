<?php

namespace App\Packages\VirtualModels\Controllers;

use Illuminate\Http\Request;
use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Contracts\VirtualModelContract;
use App\Packages\VirtualModels\Repository\VirtualModelRepository;
use App\Packages\VirtualModels\Resources\VirtualModelResource;
use App\Packages\VirtualModels\Requests\VirtualModelFormRequest;

class VirtualModelController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $virtualmodel = VirtualModel::latest()->get();
        return VirtualModelResource::collection($virtualmodel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VirtualModelFormRequest $request, VirtualModelContract $virtualmodelContract)
    {
        try {
            $virtualmodel = $virtualmodelContract->store($request);
            return (new VirtualModelResource($virtualmodel))->additional([
                'status' => 1,
                'message' => $virtualmodel->name . config('message.store.positive')
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
        return (new VirtualModelResource(VirtualModel::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VirtualModelFormRequest $request, VirtualModel $virtualmodel, VirtualModelContract $virtualmodelContract)
    {
        try {
            $virtualmodel = $virtualmodelContract->update($virtualmodel, $request);
            return (new VirtualModelResource($virtualmodel))->additional([
                'status' => 1,
                'message' => $virtualmodel->name . config('message.update.positive')
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
    public function destroy(Request $request, VirtualModelContract $virtualmodelContract)
    {
        $status = $virtualmodelContract->delete($request->all());
        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}

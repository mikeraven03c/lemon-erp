<?php

namespace App\Packages\VirtualGroups\Controllers;

use Illuminate\Http\Request;
use App\Packages\VirtualGroups\Models\VirtualGroup;
use App\Packages\VirtualGroups\Contracts\VirtualGroupContract;
use App\Packages\VirtualGroups\Resources\VirtualGroupResource;
use App\Packages\VirtualGroups\Requests\VirtualGroupFormRequest;

class VirtualGroupController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $virtualgroup = VirtualGroup::latest()->get();
        return VirtualGroupResource::collection($virtualgroup);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VirtualGroupFormRequest $request, VirtualGroupContract $virtualgroupContract)
    {
        try {
            $virtualgroup = $virtualgroupContract->store($request);
            return (new VirtualGroupResource($virtualgroup))->additional([
                'status' => 1,
                'message' => $virtualgroup->name . config('message.store.positive')
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
        return (new VirtualGroupResource(VirtualGroup::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VirtualGroupFormRequest $request, VirtualGroup $virtualgroup, VirtualGroupContract $virtualgroupContract)
    {
        try {
            $virtualgroup = $virtualgroupContract->update($virtualgroup, $request);
            return (new VirtualGroupResource($virtualgroup))->additional([
                'status' => 1,
                'message' => $virtualgroup->name . config('message.update.positive')
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
    public function destroy(Request $request, VirtualGroupContract $virtualgroupContract)
    {
        $status = $virtualgroupContract->delete($request->all());
        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}

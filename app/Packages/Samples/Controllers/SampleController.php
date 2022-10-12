<?php

namespace App\Packages\Samples\Controllers;

use Illuminate\Http\Request;
use App\Packages\Samples\Models\Sample;
use App\Packages\Samples\Contracts\SampleContract;
use App\Packages\Samples\Resources\SampleResource;
use App\Packages\Samples\Requests\SampleFormRequest;

class SampleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sample = Sample::latest()->get();
        return SampleResource::collection($sample);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SampleFormRequest $request, SampleContract $sampleContract)
    {
        try {
            $sample = $sampleContract->store($request);
            return (new SampleResource($sample))->additional([
                'status' => 1,
                'message' => $sample->name . config('message.store.positive')
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
        return (new SampleResource(Sample::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SampleFormRequest $request, Sample $sample, SampleContract $sampleContract)
    {
        try {
            $sample = $sampleContract->update($sample, $request);
            return (new SampleResource($sample))->additional([
                'status' => 1,
                'message' => $sample->name . config('message.update.positive')
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
    public function destroy(Request $request, SampleContract $sampleContract)
    {
        $status = $sampleContract->delete($request->all());
        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}

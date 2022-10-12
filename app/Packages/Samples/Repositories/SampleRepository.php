<?php

namespace App\Packages\Samples\Repository;

use App\Packages\Samples\Models\Sample;
use App\Packages\Samples\Contracts\SampleContract;
use App\Packages\Samples\Requests\SampleFormRequest;

class SampleRepository implements SampleContract
{
    public function store(SampleFormRequest $request) : Sample
    {
        return Sample::create($request->toArray());
    }

    public function update(Sample $sample, SampleFormRequest $request) : Sample
    {
        $sample->update($request->toArray());
        return $sample;
    }

    public function delete(array $ids) {
        return Sample::destroy($ids);
    }
}

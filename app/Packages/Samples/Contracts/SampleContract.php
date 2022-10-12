<?php

namespace App\Packages\Samples\Contracts;

use App\Packages\Samples\Models\Sample;
use App\Packages\Samples\Requests\SampleFormRequest;

interface SampleContract
{
    public function store(SampleFormRequest $request);
    public function update(Sample $sample, SampleFormRequest $dto);
    public function delete(array $ids);
}

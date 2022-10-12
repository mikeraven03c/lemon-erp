<?php

namespace App\Packages\VirtualModels\Contracts;

use App\Packages\VirtualModels\Models\VirtualModel;
use App\Packages\VirtualModels\Requests\VirtualModelFormRequest;

interface VirtualModelContract
{
    public function getSelectSSR(string $select);
    public function store(VirtualModelFormRequest $request);
    public function update(VirtualModel $virtualmodel, VirtualModelFormRequest $request);
    public function delete(array $ids);
}

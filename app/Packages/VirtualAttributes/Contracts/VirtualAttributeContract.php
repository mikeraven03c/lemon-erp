<?php

namespace App\Packages\VirtualAttributes\Contracts;

use App\Packages\VirtualAttributes\Models\VirtualAttribute;
use App\Packages\VirtualAttributes\Requests\VirtualAttributeFormRequest;
use App\Packages\VirtualModels\Models\VirtualModel;

interface VirtualAttributeContract
{
    public function getAttributeBySelect($virtualModelId);
    public function getAttributeByOrder(VirtualModel $model);
    public function store(VirtualAttributeFormRequest $request);
    public function update(VirtualAttribute $virtualattribute, VirtualAttributeFormRequest $dto);
    public function delete(array $ids);
}

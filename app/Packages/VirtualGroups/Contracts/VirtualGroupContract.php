<?php

namespace App\Packages\VirtualGroups\Contracts;

use App\Packages\VirtualGroups\Models\VirtualGroup;
use App\Packages\VirtualGroups\Requests\VirtualGroupFormRequest;

interface VirtualGroupContract
{
    public function store(VirtualGroupFormRequest $request);
    public function update(VirtualGroup $virtualgroup, VirtualGroupFormRequest $dto);
    public function delete(array $ids);
}

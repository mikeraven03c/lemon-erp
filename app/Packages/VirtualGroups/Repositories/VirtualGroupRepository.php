<?php

namespace App\Packages\VirtualGroups\Repositories;

use App\Packages\VirtualGroups\Models\VirtualGroup;
use App\Packages\VirtualGroups\Contracts\VirtualGroupContract;
use App\Packages\VirtualGroups\Requests\VirtualGroupFormRequest;

class VirtualGroupRepository implements VirtualGroupContract
{
    public function store(VirtualGroupFormRequest $request) : VirtualGroup
    {
        return VirtualGroup::create($request->toArray());
    }

    public function update(VirtualGroup $virtualgroup, VirtualGroupFormRequest $request) : VirtualGroup
    {
        $virtualgroup->update($request->toArray());
        return $virtualgroup;
    }

    public function delete(array $ids) {
        return VirtualGroup::destroy($ids);
    }
}

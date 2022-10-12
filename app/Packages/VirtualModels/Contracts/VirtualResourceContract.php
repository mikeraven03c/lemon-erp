<?php

namespace App\Packages\VirtualModels\Contracts;

use App\Packages\VirtualModels\Models\VirtualResource;

interface VirtualResourceContract
{
    public function getMenu();
    public function getReferenceData();
    public function getModelThroughEndpoint($endpoint);
    public function getVirtualResource() : VirtualResource;
    public function getAttributeByOrder();
    public function create(array $input) : VirtualResource;
    public function update($id, array $input) : bool;
    public function getModel() : VirtualResource;
    public function destroy($ids);
}

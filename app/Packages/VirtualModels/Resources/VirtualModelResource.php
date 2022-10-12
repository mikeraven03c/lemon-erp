<?php

namespace App\Packages\VirtualModels\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualModelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'endpoint' => $this->endpoint,
            'table_name' => $this->table_name,
            'virtual_group_id' => $this->virtual_group_id,
        ];
    }
}

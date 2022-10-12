<?php

namespace App\Packages\VirtualGroups\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualGroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'priority' => $this->priority,
        ];
    }
}

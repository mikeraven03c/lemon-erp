<?php

namespace App\Packages\VirtualModels\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualModelMenuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'endpoint' => $this->endpoint
        ];
    }
}

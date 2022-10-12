<?php

namespace App\Packages\VirtualModels\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualResourceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->name,
            'link' => $this->endpoint,
        ];
    }
}

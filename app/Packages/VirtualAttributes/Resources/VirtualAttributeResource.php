<?php

namespace App\Packages\VirtualAttributes\Resources;

use App\Lemon\Components\DataTransferObject\SelectSSRData;
use App\Packages\VirtualModels\Models\VirtualModel;
use Illuminate\Http\Resources\Json\JsonResource;

class VirtualAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        // $vModel = $this->reference
        //     ? SelectSSRData::from(VirtualModel::findOrFail($this->reference))->toArray()
        //     : null;

        // $vModel = $this->reference;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'field' => $this->field,
            'size' => $this->size,
            'show_on_form' => $this->show_on_form,
            'label' => $this->label,
            'type' => $this->type,
            'virtual_model_id' => $this->virtual_model_id,
            'is_required' => $this->is_required,
            'tab' => $this->tab,
            'is_choices' => $this->is_choices,
            'options' => $this->options,
            'order' => $this->order,
            'reference' => $this->reference,
            'field_reference' => $this->field_reference,
        ];
    }
}

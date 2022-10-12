<?php

namespace App\Packages\VirtualAttributes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualAttributeColumnResource extends JsonResource
{
    public function toArray($request)
    {
        return [

            'field' => $this->field,
            'label' => $this->label,
            'name' => $this->name,
            'required' => false,
            'showOnForm' => $this->show_on_form,
            'size' => $this->size,
            'sortable' => true,
            'type' => $this->type,
            'align' => 'left',
            'options' => $this->options,
            'reference' => $this->reference
            // 'priority' => $this->priority,
            // 'virtual_model_id' => $this->virtual_model_id,
            // 'is_required' => $this->is_required,
            // 'tab' => $this->tab,
            // 'is_choices' => $this->is_choices,
            // 'options' => $this->options,
        ];
    }
}


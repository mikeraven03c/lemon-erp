<?php

namespace App\Packages\VirtualAttributes\DataTransferObject;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class VirtualAttributeData extends Data
{
    public function __construct(
        public string $name,
        public string $field,
        public string $type,
        public string $label,
        public string $size,
        public string $order,
        public int $virtual_model_id,
        public bool $is_required,
        public bool $is_choices,
        public bool $show_on_form,
        public ?string $tab,
        public ?string  $options,
        public ?string  $reference,
        public ?string  $field_reference
    )
    {
    }

    public static function toAttribute(Request $request)
    {
        return new self(
            $request->name,
            $request->field ?? Str::snake($request->name),
            $request->type  ?? 'string',
            $request->label ?? ucwords(Str::snake($request->name, ' ')),
            $request->size ?? 'col-12',
            $request->order ?? '1',
            $request->virtual_model_id,
            false,
            false,
            $request->show_on_form ?? true,
            $request->get('tab'),
            $request->options ?? null,
            $request->has('reference') ? $request->reference : null,
            $request->field_reference ?? null
        );
    }
}

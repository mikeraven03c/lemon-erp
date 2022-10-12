<?php

namespace App\Packages\VirtualModels\DataTransferObject;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

class VirtualModelData extends Data
{
    public function __construct(
        public string $name,
        public string $table_name,
        public string $endpoint
    )
    {
    }

    public static function toDB($request)
    {
        return new self(
            $request->name,
            $request->table_name ?? Str::snake($request->name),
            $request->endpoint
        );
    }
}

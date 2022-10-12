<?php

namespace App\Lemon\Components\DataTransferObject;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapOutputName;

class SelectSSRData extends Data
{
    public function __construct(
        #[MapOutputName('value')]
        public string $id,
        #[MapOutputName('label')]
        public string $name,
    )
    {
    }
}

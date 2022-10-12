<?php

namespace App\Lemon\Publishers\Resources\Config;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class VariableResource
{
    const NAME = 'NAME';
    const PLURALNAME = 'PLURALNAME';
    const LCNAME = 'LCNAME';
    const MCOLUMN = 'MCOLUMN';
    const KEBABNAME = 'KEBABNAME';
    const LABELNAME = 'LABELNAME';

    public function __invoke($options) : Collection
    {
        $name = $options['name'] ?? 'name';
        $column = $options['column'] ?? 'name';
        return collect([
            self::NAME => ucwords($name),
            self::PLURALNAME => ucwords(Str::plural($name)),
            self::LCNAME => strtolower($name),
            self::MCOLUMN => $column,
            self::KEBABNAME => Str::kebab($name),
            self::LABELNAME => ucwords(Str::snake($name, ' '))
        ]);
    }
}

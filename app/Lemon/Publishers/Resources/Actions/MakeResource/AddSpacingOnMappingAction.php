<?php

namespace App\Lemon\Publishers\Resources\Actions\MakeResource;

use App\Lemon\Publishers\Resources\Config\FileResources;

class AddSpacingOnMappingAction
{
    public function __invoke($mode, $columns, $type, $spacing = 8)
    {
        if (
            in_array($type, ['request', 'resource', 'factory', 'dtoRequest'])
            || $mode == FileResources::VIRTUAL_COLUMNS
        ) {
            $spacing = 12;
        }

        return array_map(function ($map) use ($spacing) {
            return str_repeat(" ", $spacing) . $map;
        }, $columns);
    }
}

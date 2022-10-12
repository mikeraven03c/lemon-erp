<?php

namespace App\Lemon\Publishers\Resources\Actions\MakeResource;

use App\Lemon\Publishers\Resources\Config\FileResources;

class AddSpacingOnMappingAction
{
    public function __invoke($mode, $columns, $type, $spacing = 8)
    {
        if (
            in_array($type, ['request', 'resource', 'factory', 'dtoRequest'])
            || ($mode == FileResources::VIRTUAL_COLUMNS && $type == 'model')
        ) {
            $spacing = 12;
        } else if ($type == 'config-js')
        {
            $spacing = 0;
        } else if ($type == 'ui-columns') {
            $spacing = 2;
        }

        return $spacing == 0 ? $columns : array_map(function ($map) use ($spacing) {
            return str_repeat(" ", $spacing) . $map;
        }, $columns);
    }
}

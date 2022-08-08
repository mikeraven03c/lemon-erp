<?php

namespace App\Lemon\Publishers\Resources\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeMigrationSchemaAction
{
    public function __invoke($pack)
    {
        if ($pack->has_virtual_column) {
            $columns[] = 'data:json:nullable';
        }
        $word = Str::plural(Str::snake($pack->name));
        Artisan::call('make:migration:schema', [
            'name' => 'create_' . $word . '_table',
            '--schema' => implode(',', $columns)
        ]);
    }
}

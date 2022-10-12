<?php
namespace App\Lemon\Publishers\Resources\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Lemon\Publishers\Resources\Actions\BindFormatAction;
use App\Lemon\Publishers\Resources\Actions\MakeResourceAction;
use App\Lemon\Publishers\Resources\Actions\MakeMigrationSchemaAction;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats\BindAppPackgeFormat;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats\BindUIMenuJSFormat;
use App\Lemon\Publishers\Resources\Actions\BindAppPackage\Formats\BindUIRoutesJSFormat;

class MakeLemonResourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lemon:make:resources {name} {column=name} {--pack} {--only=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Lemon Resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isPack = $this->option('pack');
        $name = $this->argument('name');
        $only = $this->option('only');
        if ($isPack) {
            $basePath = base_path('App\\Pack\\' . ucwords($name) . 'Pack.json');
            $file = file_get_contents($basePath);
            $lcName = strtolower($name);
            $pack = json_decode($file);

            $columns = (array) $pack->columns;
        }

        if (!isset($only) || $only == 'resource') {
            (new MakeResourceAction(
                $name,
                $isPack ?
                [
                    'name' => $name,
                    'columns' => $pack->columns,
                    'has_virtual_column' => $pack->has_virtual_column,
                    'column' => $pack->target_column
                ] :
                [
                    'name' => $name,
                    'column' =>$this->argument('column')
                ]
            ))->multipleResources($this);
        }

        if ($isPack && (!isset($only) || $only == 'ui')) {
            $resources = [
                [
                    'type' => 'config-js',
                    'stub' => 'stubs/ui/v1/config.js.stub',
                    'path' => base_path('ui\\src\\packages\\' . $lcName . '\\js'),
                    'folder' => null,
                    'suffix' => '',
                    'prefix' => '',
                    'file_name' => 'config.js',
                    'has_columns' => true,
                ],
                [
                    'type' => 'resource-ui',
                    'stub' => 'stubs/ui/v1/index.vue.stub',
                    'path' => base_path('ui\\src\\packages\\' . $lcName),
                    'folder' => null,
                    'suffix' => 'Index.vue',
                    'prefix' => '',
                    'has_columns' => 'false',
                ]
            ];
            if ($pack->ui) {
                $columns = $pack->virtual_columns
                    ? array_merge($pack->columns, $pack->virtual_columns)
                    : $pack->columns;
                (new MakeResourceAction(
                    $name,
                    $isPack ?
                    [
                        'name' => $name,
                        'columns' => $columns,
                        'has_virtual_column' => $pack->has_virtual_column,
                        'column' => $pack->target_column
                    ] :
                    [
                        'name' => $name,
                        'column' =>$this->argument('column')
                    ]
                ))->customResources($resources, $this);
            }
        }

        if ($isPack && (!isset($only) || $only == 'migration')) {
            if ($pack->migration) {
                $this->info("Making Migration");
                (new MakeMigrationSchemaAction)($pack);
            }
        }

        if (
            ($isPack ? $pack->bind : true)
            && (!isset($only) || $only == 'bind')
        ) {
            (new BindFormatAction)($name, new BindAppPackgeFormat);
            $this->info("bind app");
        }
        if (
            ($isPack ? $pack->ui_bind : false)
            && (!isset($only) || $only == 'ui_bind')
        ) {
            (new BindFormatAction)($name, new BindUIRoutesJSFormat);
            $this->info("UI routes bind complete");
        }

        if (
            ($isPack ? $pack->ui_menu_bind : false)
            && (!isset($only) || $only == 'ui__menu_bind')
        ) {
            (new BindFormatAction)($name, new BindUIMenuJSFormat);
            $this->info("UI menu bind complete");
        }
    }
}

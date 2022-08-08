<?php
namespace App\Lemon\Publishers\Resources\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Lemon\Publishers\Resources\Actions\MakeResourceAction;
use App\Lemon\Publishers\Resources\Actions\BindAppPackagesAction;
use App\Lemon\Publishers\Resources\Actions\MakeMigrationSchemaAction;

class MakeLemonResourcesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lemon:make:resources {name} {column=name} {--pack}';

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
        if ($isPack) {
            $basePath = base_path('App\\Pack\\' . ucwords($name) . 'Pack.json');
            $file = file_get_contents($basePath);
            $pack = json_decode($file);

            $columns = (array) $pack->columns;
        }

        if ($isPack) {
            if ($pack->migration)
            (new MakeMigrationSchemaAction)($pack);
        }

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

        if ($isPack ? $pack->bind : true) {
            (new BindAppPackagesAction)($name);
            $this->info("bind app");
        }
    }
}

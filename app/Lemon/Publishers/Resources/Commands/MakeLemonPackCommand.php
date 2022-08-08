<?php
namespace App\Lemon\Publishers\Resources\Commands;

use Illuminate\Console\Command;
use App\Lemon\Publishers\Resources\Actions\MakeResourceAction;

class MakeLemonPackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lemon:make:pack {name} {column=name}';

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
        $name = $this->argument('name');
        $column = $this->argument('column');

        $status = (new MakeResourceAction(
            $name,
            [
                'name' => $name,
                'column' => $column
            ]
        ))->run([
            'type' => 'pack',
            'stub' => 'stubs/pack/pack.stub',
            'path' => app_path('Pack'),
            'folder' => null,
            'suffix' => 'Pack.json',
            'prefix' => '',
            'has_columns' => 'false',
        ]);

        $this->info($status);
    }
}

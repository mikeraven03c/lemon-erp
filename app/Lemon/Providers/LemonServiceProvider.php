<?php
namespace App\Lemon\Providers;

use Illuminate\Support\ServiceProvider;

class LemonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommand();
    }

    public function boot()
    {

    }

    public function registerCommand()
    {
        $this->commands([
            \App\Lemon\Publishers\Resources\Commands\MakeLemonResourcesCommand::class,
            \App\Lemon\Publishers\Resources\Commands\MakeLemonPackCommand::class,
        ]);
    }
}

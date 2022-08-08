<?php

namespace App\Next\ServiceProvider;
use Illuminate\Support\ServiceProvider;

class NextServiceProvider extends ServiceProvider
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
            \App\Next\Publishers\Commands\MakeNextResourceCommand::class,
        ]);
    }
}

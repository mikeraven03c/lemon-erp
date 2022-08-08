<?php

namespace App\Providers;

use App\Packages\Users\Contracts\UserContract;
use App\Packages\Users\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppPackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserContract::class, UserRepository::class);
        # BIND #
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

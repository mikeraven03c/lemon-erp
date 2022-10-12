<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Packages\Users\Contracts\UserContract;
use App\Packages\Users\Repository\UserRepository;

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
        $this->app->bind(
            \App\Packages\VirtualAttributes\Contracts\VirtualAttributeContract::class,
            \App\Packages\VirtualAttributes\Repositories\VirtualAttributeRepository::class
        );
        $this->app->bind(
            \App\Packages\VirtualModels\Contracts\VirtualModelContract::class,
            \App\Packages\VirtualModels\Repositories\VirtualModelRepository::class
        );
        $this->app->bind(
            \App\Packages\VirtualModels\Contracts\VirtualResourceContract::class,
            \App\Packages\VirtualModels\Repositories\VirtualResourceRepository::class
        );
        $this->app->bind(
            \App\Packages\VirtualGroups\Contracts\VirtualGroupContract::class,
            \App\Packages\VirtualGroups\Repositories\VirtualGroupRepository::class
        );
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

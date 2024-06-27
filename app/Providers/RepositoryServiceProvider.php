<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;



use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Domains\Images\Repositories\ImageRepository;


use App\Domains\User\Interfaces\UserRepositoryInterface;
use App\Domains\User\Repositories\UserRepository;

use App\Domains\Curd\Interfaces\CurdRepositoryInterface;
use App\Domains\Curd\Repositories\CurdRepository;

;










class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CurdRepositoryInterface::class, CurdRepository::class);
        
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

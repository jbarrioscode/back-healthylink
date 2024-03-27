<?php

namespace App\Providers;

use App\Repositories\Permission\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\Interfaces\RoleRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
    }
}

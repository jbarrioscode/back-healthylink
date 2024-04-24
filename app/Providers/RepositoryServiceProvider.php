<?php

namespace App\Providers;

use App\Repositories\Paciente\PacienteRepository;
use App\Repositories\Paciente\PacienteRepositoryInterface;
use App\Repositories\Permission\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\Interfaces\RoleRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\EstadosMuestrasInv\EstadosMuestrasRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\EstadosMuestrasInv\EstadosMuestrasRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra\SedesTomaMuestraRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra\SedesTomaMuestraRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\TempLote\TempLoteRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\TempLote\TempRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\Ubicacion\UbicacionRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\Ubicacion\UbicacionRepositoryInterface;
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
        $this->app->bind(
            PacienteRepositoryInterface::class,
            PacienteRepository::class
        );
        $this->app->bind(
            EncuestaInvRepositoryInterface::class,
            EncuestaInvRepository::class
        );
        $this->app->bind(
            SedesTomaMuestraRepositoryInterface::class,
            SedesTomaMuestraRepository::class
        );
        $this->app->bind(
            EstadosMuestrasRepositoryInterface::class,
            EstadosMuestrasRepository::class
        );
        $this->app->bind(
            UbicacionRepositoryInterface::class,
            UbicacionRepository::class
        );
        $this->app->bind(
            TempRepositoryInterface::class,
            TempLoteRepository::class
        );
    }
}

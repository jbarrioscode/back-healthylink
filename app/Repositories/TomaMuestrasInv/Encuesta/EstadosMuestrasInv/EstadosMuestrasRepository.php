<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EstadosMuestrasInv;

use App\Models\TomaMuestrasInv\Muestras\EstadosMuestras;
use App\Traits\AuthenticationTrait;

class EstadosMuestrasRepository implements EstadosMuestrasRepositoryInterface
{
    use AuthenticationTrait;
    public function getEstadosMuestras()
    {

        try {

            $estados = EstadosMuestras::all();

            if(!$estados) return $this->error('No hay estados registrados' , 204, []);

            return $this->success($estados, count($estados), 'Estados retornados correctamente', 200);


        } catch (\Throwable $th) {

            throw $th;
        }

    }

}

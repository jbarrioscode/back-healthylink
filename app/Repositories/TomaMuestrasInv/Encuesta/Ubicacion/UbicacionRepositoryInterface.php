<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Ubicacion;

use Illuminate\Http\Request;

interface UbicacionRepositoryInterface
{
    public function getPais(Request $request);
    public function getDepartamento(Request $request,$pais_id);
    public function getCiudad(Request $request,$departamento_id);

    public function getCiudadesForPaisId(Request $request,$pais_id);
}

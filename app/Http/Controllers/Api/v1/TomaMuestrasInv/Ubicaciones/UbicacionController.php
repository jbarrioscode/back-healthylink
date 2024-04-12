<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Ubicaciones;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\Ubicacion\UbicacionRepositoryInterface;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    private $ubicacionRepository;

    public function __construct(UbicacionRepositoryInterface $ubicacionRepository)
    {
        $this->ubicacionRepository = $ubicacionRepository;
    }

    public function getPais(Request $request)
    {
        try {

            return $this->ubicacionRepository->getPais($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getDepartamento(Request $request,$pais_id)
    {
        try {

            return $this->ubicacionRepository->getDepartamento($request,$pais_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCiudad(Request $request,$departamento_id)
    {
        try {

            return $this->ubicacionRepository->getCiudad($request,$departamento_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCiudadesForPaisId(Request $request,$pais_id)
    {
        try {

            return $this->ubicacionRepository->getCiudadesForPaisId($request,$pais_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

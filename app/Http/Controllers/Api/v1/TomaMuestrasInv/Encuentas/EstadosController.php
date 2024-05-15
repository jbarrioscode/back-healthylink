<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\EstadosMuestrasInv\EstadosMuestrasRepositoryInterface;
use Illuminate\Http\Request;

class EstadosController extends Controller
{
    private $estadosMuestrasRepository;

    public function __construct(EstadosMuestrasRepositoryInterface $estadosMuestrasRepository)
    {
        $this->estadosMuestrasRepository = $estadosMuestrasRepository;
    }

    public function getEstadosMuestras(Request $request)
    {
        try {

            return $this->estadosMuestrasRepository->getEstadosMuestras($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\TempLote\TempRepositoryInterface;
use Illuminate\Http\Request;

class TempLoteController extends Controller
{
    private $TempLoteRepository;

    public function __construct(TempRepositoryInterface $TempLoteRepository)
    {
        $this->TempLoteRepository = $TempLoteRepository;
    }
    public function guardarLoteTemp(Request $request)
    {
        try {

            return $this->TempLoteRepository->guardarLoteTemp($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLoteTemp(Request $request,$user_id,$sede_id)
    {
        try {

            return $this->TempLoteRepository->getLoteTemp($request,$user_id,$sede_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteTemp(Request $request)
    {
        try {

            return $this->TempLoteRepository->deleteTemp($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

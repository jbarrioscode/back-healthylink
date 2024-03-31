<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepositoryInterface;
use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    private $encuestaRepository;

    public function __construct(EncuestaInvRepositoryInterface $encuestaRepository)
    {
        $this->encuestaRepository = $encuestaRepository;
    }

    public function crearEncuesta(Request $request)
    {
        try {

            return $this->encuestaRepository->crearEncuesta($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function AgregarInformacionComplementaria(Request $request)
    {
        try {

            return $this->encuestaRepository->AgregarInformacionComplementaria($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function crearAsignacionAutomaticaAlote(Request $request)
    {
        try {

            return $this->encuestaRepository->crearAsignacionAutomaticaAlote($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function lotesEntrasporte(Request $request)
    {
        try {

            return $this->encuestaRepository->lotesEntrasporte($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function muestrasEntregadasBioBanco(Request $request)
    {
        try {

            return $this->encuestaRepository->muestrasEntregadasBioBanco($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function muestrasAsignadasAnevera(Request $request)
    {
        try {

            return $this->encuestaRepository->muestrasAsignadasAnevera($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

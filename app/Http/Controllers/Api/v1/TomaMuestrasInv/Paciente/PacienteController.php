<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Paciente;

use App\Http\Controllers\Controller;
use App\Repositories\Paciente\PacienteRepositoryInterface;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    private $pacienteRepository;

    public function __construct(PacienteRepositoryInterface $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function createPatient(Request $request)
    {
        try {

            return $this->pacienteRepository->createPatient($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getPatient(Request $request,$id=0)
    {
        try {

            return $this->pacienteRepository->getPatient($request,$id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function patientInformedConsent(Request $request)
    {
        try {

            return $this->pacienteRepository->patientInformedConsent($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getpatientInformedConsent(Request $request,$paciente_id)
    {
        try {

            return $this->pacienteRepository->getpatientInformedConsent($request,$paciente_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function revokeInformedConsent(Request $request)
    {
        try {

            return $this->pacienteRepository->revokeInformedConsent($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

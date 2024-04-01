<?php

namespace App\Repositories\Paciente;

use Illuminate\Http\Request;

interface PacienteRepositoryInterface
{

    public function createPatient(Request $request);
    public function getPatient(Request $request,$id);
    public function patientInformedConsent(Request $request);
    public function revokeInformedConsent(Request $request);

}

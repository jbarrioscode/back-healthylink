<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use Illuminate\Http\Request;

interface EncuestaInvRepositoryInterface
{
public function crearEncuesta(Request $request);

//ASIGNACION DE MUESTRAS A LOTE

public function crearAsignacionAutomaticaAlote(Request $reques);

public function lotesEnTrasporte(Request $request);

}

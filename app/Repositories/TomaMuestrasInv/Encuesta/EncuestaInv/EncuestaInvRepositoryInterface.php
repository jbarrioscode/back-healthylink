<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use Illuminate\Http\Request;

interface EncuestaInvRepositoryInterface
{
    public function crearEncuesta(Request $request);

    public function AgregarInformacionComplementaria(Request $request);

//ASIGNACION DE MUESTRAS A LOTE

    public function crearAsignacionAutomaticaAlote(Request $reques);

    public function lotesEnTrasporte(Request $request);

    public function muestrasEntregadasBioBanco(Request $request);

    public function muestrasAsignadasAnevera(Request $request);

    public function muestrasAsignadasAcajaEnvio(Request $request);

    public function getTempoBoxSponsor(Request $request,$biobanco_id);
    public function enviarMuestrasSponsor(Request $request);


//----------------------------------------------------------

    public function trazabilidadEncuestas(Request $request, $estado_id);

    public function trazabilidadFlujoEstadosEncuesta(Request $request, $encuesta_id);
    public function getEncuestasForCRF(Request $request);

    public function respuestasEncuesta(Request $request, $encuesta_id);

    public function respuestasInformacionHistoriaClinica(Request $request, $encuesta_id);

    public function getEnfermedadesci10(Request $request,$code);

    public function getEnfermedadesci10Onco(Request $request);

    public function guardarFilesMuestra(Request $request);


}

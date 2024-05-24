<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Reportes;
use Illuminate\Http\Request;
interface ReportesRepositoryInterface
{
public function getDataDashboard(Request $request);
public function getDataForFecha(Request $request,$dateStart,$dateEnd);
}

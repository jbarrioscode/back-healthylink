<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Reportes;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\Reportes\ReportesRepositoryInterface;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    private $reportesRepository;

    public function __construct(ReportesRepositoryInterface $reportesRepository)
    {
        $this->reportesRepository = $reportesRepository;
    }

    public function getDataDashboard(Request $request)
    {
        try {

            return $this->reportesRepository->getDataDashboard($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\TempLote;

use Illuminate\Http\Request;

interface TempRepositoryInterface
{
    public function guardarLoteTemp(Request $request);
    public function getLoteTemp(Request $request,$user_id,$sede_id);
    public function deleteTemp(Request $request);
}
//

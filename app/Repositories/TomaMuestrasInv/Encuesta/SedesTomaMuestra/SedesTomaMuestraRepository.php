<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra;

use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SedesTomaMuestraRepository implements SedesTomaMuestraRepositoryInterface
{
    use AuthenticationTrait;

    public function getSedesTomaMuestra(Request $request)
    {
        try {

            $sedes = SedesTomaMuestra::all();

            if (count($sedes) == 0) return $this->error("No se encontró sedes", 204, []);

            return $this->success($sedes, count($sedes), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function AddSedesTomaMuestra(Request $request)
    {
        DB::beginTransaction();

        try {

            $rules = [
                'nombre' => 'required|string',
            ];

            $messages = [
                'nombre.required' => 'Nombre está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $sede = SedesTomaMuestra::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            DB::commit();

            return $this->success($sede, 1, 'Sede registrada', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }
    }

}

<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\TempLote;

use App\Models\TomaMuestrasInv\Muestras\TempLote;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TempLoteRepository implements TempRepositoryInterface
{
    use AuthenticationTrait;
    public function guardarLoteTemp(Request $request)
    {

        DB::beginTransaction();

        try {

            $rules = [
                'minv_formulario_id' => 'required',
                'user_id' => 'required',
                'sede_id' => 'required',
                'tipo_muestra' => 'required',
            ];

            $messages = [
                'minv_formulario_id.required' => 'Muestra está vacio.',
                'user_id.required' => 'ID usuario está vacio.',
                'sede_id.required' => 'Sede está vacio.',
                'tipo_muestra.required' => 'Tipo Muestra está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $temp = TempLote::create([
                'minv_formulario_id' => $request->minv_formulario_id,
                'user_id' => $request->user_id,
                'sede_id' => $request->sede_id,
                'tipo_muestra' => $request->tipo_muestra,
                'lote_cerrado' => 'false',
            ]);

            DB::commit();

            return $this->success($temp, 1, 'Muestra guardada correctamente', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }

    }

    public function getLoteTemp(Request $request,$user_id,$sede_id)
    {

        try {

            $tempMuestras=TempLote::where('sede_id',$sede_id)
                    ->where('user_id',$user_id)
                    ->where('lote_cerrado','false')
                    ->where('tipo_muestra','MUESTRA')->get();

            $tempContramuestras=TempLote::where('sede_id',$sede_id)
                    ->where('user_id',$user_id)
                    ->where('lote_cerrado','false')
                    ->where('tipo_muestra','CONTRAMUESTRA')->get();

            $temp=['temp_Muestras'=>$tempMuestras,'tempContraMuestras'=>$tempContramuestras];

            if (count($temp) == 0) return $this->error('No hay muestras con este usuario en esta sede con apertura', 204, []);

            return $this->success($temp, count($temp), 'Ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function deleteTemp(Request $request)
    {
        try {

            $rules = [
                'minv_formulario_id' => 'required',
                'tipo_muestra' => 'required',
            ];

            $messages = [
                'minv_formulario_id.required' => 'Muestra está vacio.',
                'tipo_muestra.required' => 'Tipo Muestra está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $temp=TempLote::where('minv_formulario_id',$request->minv_formulario_id)
                ->where('tipo_muestra',$request->tipo_muestra)
                ->where('lote_cerrado',false)->delete();

            return $this->success($temp, 1, 'Eliminado correctamente', 200);


        } catch (\Throwable $th) {
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }
    }
}

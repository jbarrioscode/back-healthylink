<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\TempLote;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Models\TomaMuestrasInv\Muestras\TempLote;
use App\Models\User;
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
                'user_id' => 'required',
                'codigo_muestra' => 'required',
                'tipo_muestra' => 'required'
            ];

            $messages = [
                'codigo_muestra.required' => 'Codigo muestra está vacio.',
                'user_id.required' => 'ID usuario está vacio.',
                'tipo_muestra.required' => 'Tipo muestra está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $codificacion = explode('-', $request->codigo_muestra);

            $codigo_muestra = preg_split('/([0-9]+)/', $codificacion[0], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            $validacion = self::validarCodificacionLote($codificacion,$codigo_muestra, $request->tipo_muestra);
            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }


            $temp = TempLote::create([
                'minv_formulario_id' => $codigo_muestra[1],
                'user_id' => $request->user_id,
                'sede_id' => $codificacion[2],
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

    public static function validarCodificacionLote($codificacion,$codigo_muestra ,$tipo_muestra)
    {
        if (!isset($codificacion[0]) || !isset($codificacion[1]) || !isset($codificacion[2]) || !isset($codificacion[3])) {
            return 'Codigo invalido';
        }

        if ($codigo_muestra[0] !== 'MU' || $codigo_muestra[0] !== 'CM') return "Codigo invalido";

        if ($codigo_muestra[0] === 'MU' && $tipo_muestra !== 'MUESTRA') return "El codigo no pertenece a 'muestra'";

        if ($codigo_muestra[0] === 'CM' && $tipo_muestra !== 'CONTRAMUESTRA') return "El codigo no pertenece a 'contramuestra'";


        if (!FormularioMuestra::where('id', $codigo_muestra[1])->exists()) return 'La muestra no existe';

        if (!FormularioMuestra::where('code_paciente', $codificacion[1])->exists()) return 'El paciente no existe';

        if (!FormularioMuestra::where('id', $codigo_muestra[1])->where('code_paciente', $codificacion[1])->exists()) return 'El paciente y la muestra no coinciden';

        if (!SedesTomaMuestra::where('id', $codificacion[2])->exists()) return 'La sede no existe';

        if (!User::where('id', $codificacion[3])->exists()) return 'El recolector no existe';

        return '';
    }

    public function getLoteTemp(Request $request, $user_id, $sede_id)
    {

        try {

            $tempMuestras = TempLote::where('sede_id', $sede_id)
                ->where('user_id', $user_id)
                ->where('lote_cerrado', 'false')
                ->where('tipo_muestra', 'MUESTRA')->get();

            $tempContramuestras = TempLote::where('sede_id', $sede_id)
                ->where('user_id', $user_id)
                ->where('lote_cerrado', 'false')
                ->where('tipo_muestra', 'CONTRAMUESTRA')->get();

            $temp = ['temp_Muestras' => $tempMuestras, 'tempContraMuestras' => $tempContramuestras];

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


            $temp = TempLote::where('minv_formulario_id', $request->minv_formulario_id)
                ->where('tipo_muestra', $request->tipo_muestra)
                ->where('lote_cerrado', false)->delete();

            return $this->success($temp, 1, 'Eliminado correctamente', 200);


        } catch (\Throwable $th) {
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }
    }
}

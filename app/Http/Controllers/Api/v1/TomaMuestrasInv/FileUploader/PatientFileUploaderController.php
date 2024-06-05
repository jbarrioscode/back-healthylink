<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader;

use App\Http\Controllers\Controller;
use App\Models\TomaMuestrasInv\Muestras\files;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class PatientFileUploaderController extends Controller
{
    use AuthenticationTrait;
    //
    public function store(Request $request)
    {

        try {

            $request->validate([
                'filename' => 'string|required',
                'file' => 'required|mimes:pdf,xls,xlsx|max:2048'
            ]);

            if ($request->hasFile('file')) {
                //This is to get the extension of the image file just uploaded
                $extension = $request->file('file')->getClientOriginalExtension();
                $size = $request->file('file')->getSize();

                $filename = $request->filename;
                return $extension .'---'.$filename . '---'. $size;
                /*$path = $request->file('file')->storeAs(
                    'images',
                    $filename,
                    's3'
                );*/
                /*$file = files::create([
                    'filename' => $request->filename,
                    'mime' => $request->fileExtension,
                    'path' => $path,
                    'size' => '1080',
                    'minv_formulario_id' => $request->minv_formulario_id
                ]);

                return $this->success($file, 1, 'File Saved', 201);*/

            }


        } catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()], 404);
        }

    }
}

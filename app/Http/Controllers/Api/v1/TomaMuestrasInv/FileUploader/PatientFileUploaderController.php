<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader;

use App\Http\Controllers\Controller;
use App\Models\TomaMuestrasInv\Muestras\files;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientFileUploaderController extends Controller
{
    use AuthenticationTrait;
    //
    public function store(Request $request)
    {

        try {

            $request->validate([
                'file' => 'required|mimes:pdf,xls,xlsx|max:2048'
            ]);

            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $fileextension = $file->getClientOriginalExtension();
                $filesize = $file->getSize();
                $filename = $file->hashName();

                $path = 'images/'. $filename;
                Storage::disk('s3')->put($path, $file);

                $fileCreated = files::create([
                    'filename' => $filename,
                    'mime' => $fileextension,
                    'path' => Storage::disk('s3')->url($path),
                    'size' => $filesize,
                    'minv_formulario_id' => $request->minv_formulario_id
                ]);

                return response()->json(['url' => $fileCreated], 200);

            }


        } catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()], 404);
        }

    }
}

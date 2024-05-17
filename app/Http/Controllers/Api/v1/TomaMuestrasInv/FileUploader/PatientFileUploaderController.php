<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientFileUploaderController extends Controller
{
    //
    public function store(Request $request)
    {

        try {

            $folder = "imagenes";
            $path = Storage::disk('s3')->put($folder, $request->image, 'public');
            return response()->json([
                'path' => $path,
                'msg' => 'success'
            ]);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}

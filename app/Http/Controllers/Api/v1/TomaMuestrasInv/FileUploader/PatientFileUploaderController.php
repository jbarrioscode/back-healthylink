<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader;

use App\Http\Controllers\Controller;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Http\Request;

class PatientFileUploaderController extends Controller
{
    //
    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf,docx,doc,pptx,ppt,xls,xlsx,jpg,png|max:2048'
        ]);
        $file = $request->file('file');

        //create s3 client
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'scheme' => 'http',
            /*'http'    => [
                'verify' => 'C:\Users\HP\Desktop\mibCode\AWS\healthylink.pem'
            ],*/
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
        $keyname = 'uploads/' . $file->getClientOriginalName();
        //create bucket
        /*if (!$s3->doesBucketExist(env('AWS_BUCKET'))) {
            // Create bucket if it doesn't exist
            try {
                $s3->createBucket([
                    'Bucket' => env('AWS_BUCKET'),
                ]);
            } catch (S3Exception $e) {
                return response()->json([
                    'Bucket Creation Failed' => $e->getMessage()
                ]);
            }
        }*/
        //upload file
        try {
            $result = $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $keyname,
                'Body' => fopen($file, 'r'),
                'ACL' => 'public-read'
            ]);
            // Print the URL to the object.
            return response()->json([
                'message' => 'File uploaded successfully',
                'file link' => $result['ObjectURL']
            ]);
        } catch (S3Exception $e) {
            return response()->json([
                'Upload Failed' => $e->getMessage()
            ]);
        }
    }
    /*try {

        $disk = "healthylink";

        //$fileName = $request->file('image')->getFilename();
        $fileName = $request->file('image')->getClientOriginalName();

        //return $fileName;
        //$fileImage = Storage::get($fileName);
        $fileImage = storage_path($fileName);

        Storage::disk($disk)->put($fileName, $fileImage);

        return Storage::disk($disk)->url($fileName);
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }*/
}

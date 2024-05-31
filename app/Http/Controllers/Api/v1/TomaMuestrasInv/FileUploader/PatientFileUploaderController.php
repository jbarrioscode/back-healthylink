<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader;

use App\Http\Controllers\Controller;
use App\Traits\AuthenticationTrait;
use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class PatientFileUploaderController extends Controller
{
    use AuthenticationTrait;
    //
    public function store(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'filename' => 'string|required',
                'directory' => 'string|required',
                File::types(['pdf', 'xls', 'xlsx'])
                ->max(12*1024),
            ]);

            if ($validator->fails()) return $this->error($validator->errors(), 422, []);

            //Step 2 Starts
            $filename = $request->filename;
            $directory = $request->directory;
            $surveyNum = $request->minv_formulario_id;
            $extension = $request->fileExtension;

            $s3 = config('filesystems.disks.healthylink');

            $client = new S3Client([
                'version' => 'latest',
                'region' => $s3['region'],
                'credentials' => [
                    'key' => $s3['key'],
                    'secret' => $s3['secret'],
                ]
            ]);

            $bucket = $s3['bucket'];
            $prefix = $directory . '/';
            $acl = 'public-read';
            $expires = '+30 minutes';
            $formInputs = [
                'acl' => $acl,
                'key' => $prefix . $filename,
            ];

            $options = [
                ['acl' => $acl],
                ['bucket' => $bucket],
                ['starts-with', '$key', $prefix],
            ];
            //Step 2 Ends

            //Step 3 Starts
            $postObject = new PostObjectV4($client, $bucket, $formInputs, $options, $expires);
            //Step 3 Ends

            //Step 4 Starts
            $attributes = $postObject->getFormAttributes();
            $inputs = $postObject->getFormInputs();
            return response([
                'attributes' => $attributes,
                'inputs' => $inputs,
                'url' => $attributes['action'].'/'.$directory.'/'. $filename
            ]);
            //Step 4 Ends


        } catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()], 404);
        }

    }
}

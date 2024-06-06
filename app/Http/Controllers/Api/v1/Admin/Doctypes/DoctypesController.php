<?php

namespace App\Http\Controllers\Api\v1\Admin\Doctypes;

use App\Http\Controllers\Controller;
use App\Models\DocType;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;

class DoctypesController extends Controller
{
    //
    use AuthenticationTrait;

    public function all()
    {
        $docTypes = DocType::all();

        if (!$docTypes) return $this->error('Empty Doctype Query', 204, []);

        return $this->success($docTypes, count($docTypes), 'Doctypes', 200);

    }

}

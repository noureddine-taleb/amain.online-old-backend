<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Response;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected function response(int $status, String $resource, $data = null)
    {
        return response()->json(["feedback" => $resource ." ". Response::where("status",$status)->firstOrFail()->response, "data" => $data ], $status);
    }

    protected function buildFailedValidationResponse(Request $request, array $errors) {
        $errs = [];
        foreach ($errors as $field => $error) {
            foreach ($error as $value) {
                $errs[] = $field . " : " . $value;
            }
        }
        return response()->json(["errors" =>$errs], 422);
    }
}

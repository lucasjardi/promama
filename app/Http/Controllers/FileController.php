<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //

    private $default_token = "token1";

    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function getFile(Request $request, $filename)
    {
    	if ( $request->api_token !== $this->default_token ) {
            
            return response()->download(storage_path('app/'.$filename), null, [], null);
            // return response()->download(storage_path($filename);

        } else {
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }
    }
}

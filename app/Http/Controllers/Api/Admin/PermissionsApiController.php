<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\PermissionsResource;







class PermissionsApiController extends Controller
{
    //
    public function index(Request $request)
    {

        $permissions=Permission::all();

        return response()->json([
            'permissions' => PermissionsResource::collection($permissions),
          

            ])->setStatusCode(200);  
       


    }
   
}

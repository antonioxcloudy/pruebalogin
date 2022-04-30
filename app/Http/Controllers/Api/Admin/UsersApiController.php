<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;







class UsersApiController extends Controller
{
    //
    public function index(Request $request)
    {

        $search = $request->input('q', '');
        $perPage = (int)$request->input('perPage', 10);
        $page = (int)$request->input('page', 1);
        $sortBy = $request->input('sortBy', 'id');
        if ($sortBy === null) $sortBy = 'id';
        $sortDesc = $request->input('sortDesc', false);
        $sortDesc = $sortDesc === "true";

        $search = Str::lower($search);
      

        $users = User::with(['roles:title'])->where('name','like',"%$search%")->orWhere('email','like',"%$search%");
        $totalCount = $users->count();

        $users->orderBy($sortBy, $sortDesc ? 'desc' : 'asc');
        $users = $users->get();
       
        
        return response()->json([
            'users' => UserResource::collection($users),
            'total' => $totalCount

            ])->setStatusCode(200);  
      
    }

    public function adduser(Request $request)
    {
        
        // $name = $request->input('data.name');
        // $email = $request->input('data.email');
        // $password = $request->input('data.password');
        
        // User::create([
        //     'name'=>$name,
        //     'email'=>$email,
        //     'password'=>$password
        // ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),

        ]);

        // $user=User::create($request->all());
        $user->roles()->sync($request->input('roles.*.id', []));
        return response()->json([
            'status' => true,
            'user_id' => $user->id
        ])->setStatusCode(200);


    }
    public function deleteuser(int $id ){


        $user = User::find($id);
        if ($user === null)
            return response()->json(['status' => false], 404);

        $user->delete();
        return response()->json(['status' => true]);

    }

}

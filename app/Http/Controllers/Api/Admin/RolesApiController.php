<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;





class RolesApiController extends Controller
{
    //
    public function index(Request $request)
    {
        //Valores pasados por el request

        $search = $request->input('q', '');
        $perPage = (int)$request->input('perPage', 10);
        $page = (int)$request->input('page', 1);
        $sortBy = $request->input('sortBy', 'id');
        if ($sortBy === null) $sortBy = 'id';
        $sortDesc = $request->input('sortDesc', false);
        $sortDesc = $sortDesc === "true";

        $search = Str::lower($search);
        $roles = Role::query();

        //Si no lo hago asi no puedo poner los %%

        $roles->where(function ($q) use ($search) {
            $q->Where(DB::raw('LOWER(title)'), 'like', "%$search%");
        });

       

        $roles->orderBy($sortBy, $sortDesc ? 'desc' : 'asc');
        $roles = $roles->get();
        $totalCount = $roles->count();
        $roles = $roles->skip($page * $perPage - $perPage)->take($perPage);
        return response()->json([
            'users' => RoleResource::collection($roles),
            'total' => $totalCount
        ])->setStatusCode(200);


        // return new RoleResource(Role::paginate($request->perPage));


    }
    public function addrole(Request $request)
    {

        $role = Role::create([
            'title' => $request->input('title'),
           

        ]);


        // $user=User::create($request->all());
        $role->permissions()->sync($request->input('permissions.*.id', []));
        return response()->json([
            'status' => true,
            'role_id' => $role->id
        ])->setStatusCode(200);



       


    }
    public function deleterole(int $id ){


        $role = Role::find($id);
        if ($role === null)
            return response()->json(['status' => false], 404);

        $role->delete();
        return response()->json(['status' => true]);

    }
}

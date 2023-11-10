<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Menu;
use Validator;
use Str;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $data['search'] = $request->search ?? '';
        $data['roles'] = Role::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('role_name', 'like', '%'.$search.'%');
            })
            ->get();

        return view('admin.role_permission.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'role_id' => 'required',
        ]);

        if ($validator->passes()) {
            if(!empty($request->menus)){
                RolePermission::where('role_id', $request->role_id)->delete();
                foreach($request->menus as $menu){
                    $role_permission = new RolePermission();
                    $role_permission->role_id = $request->role_id;
                    $role_permission->menu_id = $menu;
                    $role_permission->save();
                }
            }

            return response()->json(['success' => true, 'mgs' => 'Role Permission Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['role'] = Role::find($id);
        
        $data['menus'] = Menu::with(['permission' => function ($query) use ($id) {
                $query->where('role_id', $id);
            }])
            ->where('module', 1)
            ->get();
        $data['total_menu_permission'] = RolePermission::where('role_id', $id)->count();
        
        return view('admin.role_permission.role_permissions', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

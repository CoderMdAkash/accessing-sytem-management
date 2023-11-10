<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['roles'] = Role::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('role_name', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'role_name' => 'required|unique:roles',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            $role = new Role();
            $role->role_name = $request->role_name;
            $role->status = $request->status;
            $role->save();

            return response()->json(['success' => true, 'mgs' => 'Role Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['role'] = Role::findOrFail($id);
        return view('admin.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'role_name' => 'required',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            $role = Role::findOrFail($id);
            $role->role_name = $request->role_name;
            $role->status = $request->status;
            $role->save();

            return response()->json(['success' => true, 'mgs' => 'Role Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            Role::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Role Successfully Deleted']);
        }
    }
}

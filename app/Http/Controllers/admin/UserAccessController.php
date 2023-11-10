<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Role;
use Str;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';

        $data['users'] = User::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.user.list', $data);
    }

    public function edit(Request $request){
        $data['roles'] = Role::all();
        $data['user_id'] = $request->user_id;
        $data['user_role'] = $request->role;
        
        return view('admin.user.role', $data);
    }
    public function update(Request $request){
        $validator =  Validator::make($request->all(), [
            'user_id' => 'required',
            'role' => 'required',
        ]);

        if ($validator->passes()) {

            $user = User::find($request->user_id);
            $user->role = $request->role;
            $user->save();

            return response()->json(['success' => true, 'mgs' => 'Role Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }
}

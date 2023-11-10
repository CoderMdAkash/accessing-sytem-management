<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use Validator;
use Str;

class ProfileSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Auth::user();
        return view('admin.profile.index', compact('profile'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            "old_password" => "required",
            "re_password" => "required",
            "new_password" => "required|min:6",
        ]);

        if ($validator->passes()) {

            $admin_id = Auth::user()->id;
            $currentPassword = $request->old_password;
            $oldPassword = User::find($admin_id)->password;

            if(Hash::check($currentPassword, $oldPassword)){
                if($request->new_password == $request->re_password){
                    $admin_new_password = bcrypt($request->new_password);
                    User::where('id', $admin_id)->update(['password' => $admin_new_password]); 
                    return response()->json(['success' => true, 'mgs' => 'Password Changed Successfully']);

                }else{
                    return response()->json(['error' => true, 'mgs' => 'New Password Re-Password Does Not not Matched']);
                }
            }else{
                return response()->json(['error' => true, 'mgs' => 'Old Password Does not matched']);
            }
        
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            "name" => "required",
        ]);

        if ($validator->passes()) {
            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/profile/'), $imageName);
            }
            $user = User::find(Auth::id());
            $user->name = $request->name;
            
            if($request->image){
                $user->avatar = $imageName;
            }
            $user->save();

            return response()->json(['success' => true, 'mgs' => 'Profile Updated Successfully']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

}

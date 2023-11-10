<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Setting;
use App\Models\Role;
use Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email'     => 'required',
            'phone'     => 'required',
            'address'   => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('logo')){ 
                $validator =  Validator::make($request->all(), [
                    'logo'      => 'required|image|mimes: jpeg,png,jpg',
                ]);
                $logoName = 'logo-'.date('d.m.Y.h.s').'.'.$request->logo->extension();  
                $request->logo->move(public_path('frontend/logo/'), $logoName);
            }
            if($request->hasfile('meta_logo')){ 
                $validator =  Validator::make($request->all(), [
                    'meta_logo' => 'required|image|mimes: jpeg,png,jpg',
                ]);
                $meta_logoName = 'meta_logo-'.date('d.m.Y.h.s').'.'.$request->meta_logo->extension();  
                $request->meta_logo->move(public_path('frontend/logo/'), $meta_logoName);
            }

            $setting = Setting::find($request->id);
            $setting->email     = $request->email;
            $setting->phone     = $request->phone;
            $setting->facebook  = $request->facebook;
            $setting->twitter   = $request->twitter;
            $setting->linkedin  = $request->linkedin;
            $setting->whatsapp = $request->whats_app;
            $setting->address   = $request->address;
            if($request->logo){
                $setting->logo = $logoName;
            }
            if($request->meta_logo){
                $setting->meta_logo = $meta_logoName;
            }
            $setting->save();

            return response()->json(['success' => true, 'mgs' => 'Setting Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    
}

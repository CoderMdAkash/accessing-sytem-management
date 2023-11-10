<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Menu;
use App\Models\Module;
use App\Models\Setting;
use App\Models\Role;

class MasterController extends Controller
{
    public function master(){
        $user = $data['user'] = Auth::user();
        $base_url = str_replace(url('/').'/', '', url()->current());

        $data['module'] = $module = Module::where('url', $base_url)->where('status', 1)->first();

        $data['menus'] = $menus = Menu::join('role_permissions', 'role_permissions.menu_id', '=', 'menus.id')
            ->join('roles', 'roles.id', '=', 'role_permissions.role_id')
            ->where('role_permissions.status', 1)
            ->where('menus.active', 1)
            ->where('roles.status', 1)
            ->where('menus.level', 1)
            ->where('menus.module', $module->id)
            ->where('menus.menu_show', 1)
            ->where('roles.id', $user->role)
            ->orderBy('menus.serial')
            ->select('menus.*')
            ->get();

        foreach($menus as $menu){
            $menu->sub_menus = Menu::join('role_permissions', 'role_permissions.menu_id', '=', 'menus.id')
                ->join('roles', 'roles.id', '=', 'role_permissions.role_id')
                ->where('role_permissions.status', 1)
                ->where('menus.active', 1)
                ->where('roles.status', 1)
                ->where('menus.level', 2)
                ->where('menus.menu_show', 1)
                ->where('menus.parent_menu_id', $menu->id)
                ->where('roles.id', $user->role)
                ->where('menus.module', $module->id)
                ->orderBy('menus.serial', 'asc')
                ->select('menus.*')
                ->get();
        }

        $data['setting'] = Setting::find(1);
        $data['role'] = Role::find(Auth::user()->role);

        return view('admin.master', $data);
    }
}

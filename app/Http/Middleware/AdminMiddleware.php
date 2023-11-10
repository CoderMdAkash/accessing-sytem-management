<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Models\Menu;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route()->getName();

        if(Auth::check() && Auth::user()->type == 2 && Auth::user()->status == 1 && Auth::user()->verified == 1){

            $menus = Menu::join('role_permissions', 'role_permissions.menu_id', '=', 'menus.id')
                ->join('roles', 'roles.id', '=', 'role_permissions.role_id')
                ->where('role_permissions.status', 1)
                ->where('menus.active', 1)
                ->where('roles.status', 1)
                ->where('menus.route', $route)
                ->where('roles.id', Auth::user()->role)
                ->count();
                
            if($menus > 0 || $route == 'admin.master'){
                return $next($request);
            }else{
                return response("<h3 class='text-center mt-5'>You have not enought Permission!</h3>");
            }

        }else{
            return redirect('admin-login');
        }
    }
}

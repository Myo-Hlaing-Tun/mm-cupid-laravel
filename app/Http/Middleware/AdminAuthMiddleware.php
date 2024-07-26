<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('admin')->user() != null){
            $route          = $request->path();
            $exploded_route = explode('/',$route);
            $route_group    = $exploded_route[0] . "/" . $exploded_route[1];
            $permissions = Session::get('permission');
            $auth = false;
            foreach($permissions as $permission){
                if($permission->route == $route_group){
                    $auth = true;
                }
            }
            if($auth){
                return $next($request);
            }
            else{
                abort(403);
            }
        }
        else{
            return redirect('admin-backend');
        }
    }
}

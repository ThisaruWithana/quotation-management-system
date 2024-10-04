<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Route;
use App\Models\RolePermission;


class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current_route = Route::currentRouteName();
        $role_id = Auth::user()->role_id;

        if($role_id != 5 && $role_id != 1 && $current_route != "user.my-password-reset" && !is_null($current_route) && $current_route != "user.my-profile" && $current_route != "user.my-profile-edit"){

            $result = RolePermission::join('permissions','permissions.id','=','role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id',$role_id)
                ->where('permissions.name',$current_route)
                ->where('role_has_permissions.status','=',1)
                ->count();

            if($result == 0){
                abort(403);
            }
        }
        return $next($request);
    }
}

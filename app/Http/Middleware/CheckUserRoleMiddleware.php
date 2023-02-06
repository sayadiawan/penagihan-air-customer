<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRoleMiddleware
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
    $user = Auth::user();
    $roles = Role::get();
    $get_role = array();

    foreach ($roles as $key => $value) {
      array_push($get_role, $value->id_roles);
    }

    if (in_array($user->roles_id, $get_role)) {
      return $next($request);
    }

    abort(401);
  }
}
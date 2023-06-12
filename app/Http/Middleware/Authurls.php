<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class Authurls
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

        $route_p = $request->route()->parameters();
        //dd($rr);
        $qq = array_values($route_p)[0];
        //dd($qq);

        $str = ltrim($qq, 'backend.');
        //dd($str);


        $getrole= DB::table('roles')->where('id',auth()->user()->role_id)->get();
        $per = explode(",",$getrole[0]->permission_id);
        $acc = explode(",",$getrole[0]->access_id);
        //dd(Auth::user());


       
        //$name_u = 'warehouse-all-warehouse';
        $getrole= DB::table('permission_access')->where('u_rl',$str )->get();
        $tt = $getrole[0]->permission_id;
        //dd($tt);


if(in_array('', $per))
{
    return $next($request);
}
elseif(!in_array($tt, $per))
{
    return redirect()->back()->with('error',__('Sorry, you are not authorized to access that location.'));
}
return $next($request);
}
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MantriMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->guest()){
            return redirect('/');
        }
        else if(auth()->user()->roles_id != 2){
            abort(403);
        }
        else if(auth()->user()->status == "rejected"){
            abort(403);
        }
        else if(auth()->user()->status == "disable"){
            abort(403);
        }
        else if(auth()->user()->status == "pending"){
            abort(403);
        }
        return $next($request);
    }
}
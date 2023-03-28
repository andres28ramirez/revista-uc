<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if($user->urol->rol->nombre != "Administrador"){
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}

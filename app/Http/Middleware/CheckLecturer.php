<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLecturer
{

    public function handle(Request $request, Closure $next)
    {

        if (auth()->user()->roles == 'lecturer') {
            return $next($request);
        }

        return response("Not Allowed to Visit This Page", 403);
    }
}

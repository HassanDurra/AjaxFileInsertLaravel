<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LoginUsers as LoggedUsers;
class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checkUser = LoggedUsers::where("sessionId" , session()->getId())->first();
        if($request->session()->has("admin") && $checkUser != null ){

        }
        else
        {
            return redirect()->route('Auth.login')->with("error" , 'Login Before Accessing Dashboard');
        }

        return $next($request);
    }
}

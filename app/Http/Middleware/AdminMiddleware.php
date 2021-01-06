<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if ($request->session()->get('admin') === null) {
            // user value cannot be found in session
            return redirect('/login');
        }

        return $next($request);

    /*    if(auth()->user()->role == 'Admin'){
          return $next($request);
        }
        return redirect('home')->with('error','Permission Denied!!! You do not have administrative access.');*/

        //return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Session;

class UserAuth extends Middleware
{

  public function handle($request, Closure $next)
  {
    if (!Session::has('id')) {
      return redirect('/bank');
    }
    return $next($request);
  }
}

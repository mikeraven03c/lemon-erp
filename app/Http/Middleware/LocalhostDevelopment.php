<?php
namespace App\Http\Middleware;
use Closure;
class LocalhostDevelopment
{
  public function handle($request, Closure $next)
  {
    if (env('APP_ENV', 'development') == 'local') {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://localhost:8080')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    } else {
        return $next($request);
    }
  }
}
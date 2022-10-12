<?php
namespace App\Http\Middleware;
use Closure;
use App\Packages\Users\Models\User;
use Illuminate\Support\Facades\Auth;

class TestDevelopment
{
  public function handle($request, Closure $next)
  {
    if (env('APP_ENV', 'local') == 'local') {
        if (!AUTH::check()) {
          Auth::login(User::first());
        }
    }
    return $next($request);
  }
}
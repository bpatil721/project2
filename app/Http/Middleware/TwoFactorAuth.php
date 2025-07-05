<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('user')->user();
        if ($user->google2fa_secret && $user->two_fa_status == 0)
        {
            return redirect()->route('2fa-verify');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FilterVerifiedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();

        if (!$user->verified) {
            $user->sendVerificationEmail();
            return redirect('/verifyemail')->withErrors(['Account is not yet verified']);
        }

        return $next($request);
    }
}

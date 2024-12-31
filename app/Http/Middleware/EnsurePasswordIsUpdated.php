<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePasswordIsUpdated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->password) {
            return redirect()->route('profile.show')
                ->with('flash.banner', 'Please set your password before continuing.')
                ->with('flash.bannerStyle', 'danger');
        }

        return $next($request);
    }
}
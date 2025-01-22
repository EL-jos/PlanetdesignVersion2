<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class EnsureUserCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifiez si le cookie 'user' existe
        if (!$request->cookie('user-planetdesign')) {
            $user = User::create([]);

            if ($user) {
                // Durée en minutes (2 ans)
                $duration = 2 * 365 * 24 * 60;

                // Créer un cookie et l'attacher à la réponse
                Cookie::queue('user-planetdesign', $user->id, $duration);

                Session::put('user', $user->id);
            }
        }else{
            Session::put('user', $request->cookie('user-planetdesign'));
        }
        return $next($request);
    }
}

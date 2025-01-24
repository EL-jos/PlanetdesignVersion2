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
        //dd($request->cookie('user-planetdesign'));

        $userId = $request->cookie('user-planetdesign');

        // Si le cookie n'existe pas ou est vide
        if (!$userId) {
            // Créer un nouvel utilisateur
            $user = User::create([]);

            if ($user) {
                // Durée du cookie en minutes (2 ans)
                $duration = 2 * 365 * 24 * 60;

                // Créer un cookie et l'attacher à la réponse
                Cookie::queue(Cookie::make('user-planetdesign', $user->id, $duration));

                // Stocker l'ID utilisateur dans la session
                Session::put('user', $user->id);
            }
        } else {
            // Si le cookie existe, l'enregistrer dans la session
            Session::put('user', $userId);
        }
        return $next($request);
    }
}

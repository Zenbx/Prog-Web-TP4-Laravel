<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Vérifier si la session est encore valide
        if (!$request->session()->has('last_activity')) {
            $request->session()->put('last_activity', time());
        } else {
            $lastActivity = $request->session()->get('last_activity');
            $timeout = 3600; // 1 heure en secondes

            if ((time() - $lastActivity) > $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
            }
        }

        $request->session()->put('last_activity', time());

        return $next($request);
    }
}
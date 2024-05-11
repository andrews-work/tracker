<?php

// app/Http/Middleware/CheckAuthLevel.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthLevel {

    // handle auth level 
    public function handle(Request $request, Closure $next, ...$levels) {

        // get user
        $user = Auth::user();

        // if user is auth, continue
        if ($user && in_array($user->auth_level, $levels)) {
            return $next($request);
        }
        
        // else redirect home
        return redirect('/home');
    }
}


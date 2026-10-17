<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password) {
            $exemptRoutes = ['password.change', 'password.update', 'logout'];

            if (! in_array($request->route()?->getName(), $exemptRoutes, true)) {
                return redirect()->route('password.change')->with(
                    'warning',
                    'Demi keamanan akunmu, kamu wajib mengganti kata sandi bawaan terlebih dahulu.'
                );
            }
        }

        return $next($request);
    }
}

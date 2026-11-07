<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach strong security headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // X-Frame-Options: Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // X-Content-Type-Options: Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer-Policy: Protect privacy on external navigations
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy: Restrict unused browser hardware features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content-Security-Policy: Enforce local-only assets and prevent unauthorized external script execution
        $csp = "default-src 'self'; "
            ."script-src 'self' 'unsafe-inline' 'unsafe-eval'; "
            ."style-src 'self' 'unsafe-inline'; "
            ."img-src 'self' data: blob:; "
            ."font-src 'self' data:; "
            ."connect-src 'self'; "
            ."frame-ancestors 'self'; "
            ."form-action 'self' https://www.google.com;";

        $response->headers->set('Content-Security-Policy', $csp);

        // Strict-Transport-Security (HSTS) if connection is secure or in production
        if ($request->isSecure() || app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Cache-Control: Mencegah browser menyimpan halaman sensitif ke dalam cache (Mencegah akses via tombol Back browser sesudah logout)
        if ($request->user() || $request->is('dashboard*', 'master*', 'bk*', 'siswa*', 'profile*', 'notifikasi*', 'ganti-password*', 'laporan-periodik*', 'two-factor*', 'login*')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
        }

        return $response;
    }
}

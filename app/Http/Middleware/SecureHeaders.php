<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * The headers that should be set on all responses.
     *
     * @var array<string, string>
     */
    protected $headers = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; connect-src 'self'; frame-src 'self'; object-src 'none'; base-uri 'self';",
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        'Cache-Control' => 'no-store, max-age=0',
        'Pragma' => 'no-cache',
    ];

    /**
     * Headers that are only applied when using HTTPS.
     *
     * @var array<string, string>
     */
    protected $httpsOnlyHeaders = [
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach ($this->headers as $headerName => $headerValue) {
            $response->headers->set($headerName, $headerValue);
        }

        // Only add HTTPS-specific headers if the request is secure
        if ($request->secure() && config('app.env') === 'production' && config('app.force_https', true)) {
            foreach ($this->httpsOnlyHeaders as $headerName => $headerValue) {
                $response->headers->set($headerName, $headerValue);
            }
        }

        return $response;
    }
}

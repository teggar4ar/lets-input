<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RateLimitLogin
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new rate limit middleware instance.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply rate limiting to login route
        if (!$request->routeIs('login') || $request->isMethod('get')) {
            return $next($request);
        }

        $key = 'login.' . $request->ip();

        // Allow 5 login attempts in 1 minute
        $maxAttempts = 5;
        $decayMinutes = 1;

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildResponse($key, $maxAttempts);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        // If successful login, clear the rate limiter
        if (
            $response->getStatusCode() === 302 &&
            !Str::contains($response->headers->get('Location'), 'login')
        ) {
            $this->limiter->clear($key);
        }

        return $response;
    }

    /**
     * Build the rate limited response.
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return \Illuminate\Http\Response
     */
    protected function buildResponse(string $key, int $maxAttempts): Response
    {
        $seconds = $this->limiter->availableIn($key);

        return back()->withInput()->withErrors([
            'email' => [
                "Too many login attempts. Please try again in {$seconds} seconds."
            ],
        ]);
    }
}

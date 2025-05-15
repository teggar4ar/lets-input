<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventRequestsDuringMaintenance
{
    /**
     * The URIs that should be accessible while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/livewire/upload-file',
        '/livewire/message/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->isDownForMaintenance()) {
            $path = $request->path();

            foreach ($this->except as $exceptPath) {
                if ($exceptPath !== '/' && $path === $exceptPath) {
                    return $next($request);
                }

                $exceptPath = trim($exceptPath, '/');

                if ($exceptPath !== '' && $path === $exceptPath) {
                    return $next($request);
                }

                if (str_ends_with($exceptPath, '*')) {
                    $exceptPath = substr($exceptPath, 0, -1);

                    if (str_starts_with($path, $exceptPath)) {
                        return $next($request);
                    }
                }
            }

            // Redirect to maintenance page or return 503 response
            return response()->view('errors.503', [], 503);
        }

        return $next($request);
    }
}

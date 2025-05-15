<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventXssAttacks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get all request inputs
        $input = $request->all();

        // Recursively sanitize input data
        array_walk_recursive($input, function (&$value) {
            // Detect potential XSS attack patterns in strings
            if (is_string($value)) {
                // Check for common XSS patterns
                $suspiciousPatterns = [
                    // Script tags
                    '/<script\b[^>]*>(.*?)<\/script>/i',
                    // JavaScript events
                    '/on\w+\s*=/i',
                    // JavaScript URLs
                    '/javascript\s*:/i',
                    // Base64 encoded JavaScript
                    '/data\s*:[^;]*base64/i',
                    // iFrame injection
                    '/<iframe\b[^>]*>(.*?)<\/iframe>/i',
                    // Object/embed tags
                    '/<object\b[^>]*>(.*?)<\/object>/i',
                    '/<embed\b[^>]*>(.*?)<\/embed>/i',
                    // Expression injection
                    '/expression\s*\(/i',
                    // VBScript injection
                    '/vbscript\s*:/i',
                    // Meta refresh/redirect
                    '/<meta\b[^>]*\bhttp-equiv\s*=\s*(["\']?)refresh\1[^>]*>/i',
                    // SVG script
                    '/<svg\b[^>]*>.*?<script\b[^>]*>(.*?)<\/script>.*?<\/svg>/is',
                ];

                foreach ($suspiciousPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        abort(403, 'Potential XSS attack detected.');
                    }
                }

                // Encode < and > symbols for all inputs
                $value = str_replace(['<', '>'], ['&lt;', '&gt;'], $value);
            }
        });

        // Replace the request input with our sanitized version
        $request->merge($input);

        return $next($request);
    }
}

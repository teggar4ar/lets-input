<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DetectSuspiciousRequests
{
    /**
     * List of suspicious URI patterns to check
     *
     * @var array<string>
     */
    protected $suspiciousUris = [
        'wp-admin',
        'wp-login',
        'wp-content',
        'administrator',
        'admin.php',
        'xmlrpc.php',
        'phpmyadmin',
        '.env',
        'config.php',
        'shell',
        'backdoor',
        '.git',
        '.svn',
        '.DS_Store',
        '.htaccess',
        '.htpasswd',
        'etc/passwd',
        'etc/shadow',
        'proc/self/environ',
    ];

    /**
     * Suspicious user agent patterns
     *
     * @var array<string>
     */
    protected $suspiciousUserAgents = [
        'nikto',
        'sqlmap',
        'nmap',
        'netsparker',
        'dirbuster',
        'metasploit',
        'w3af',
        'acunetix',
        'burpsuite',
        'harvester',
        'scrapbot',
        'semrush',
        'ahrefs',
        'curl',
        'libwww-perl',
        'python-requests',
        'zgrab',
        'go-http-client'
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
        // Check for suspicious URIs
        $uri = strtolower($request->getRequestUri());
        foreach ($this->suspiciousUris as $pattern) {
            if (strpos($uri, $pattern) !== false) {
                $this->logSuspiciousActivity($request, 'Suspicious URI pattern detected: ' . $pattern);
                return response('Not Found', 404);
            }
        }

        // Check for suspicious user agents
        $userAgent = strtolower($request->header('User-Agent') ?? '');
        foreach ($this->suspiciousUserAgents as $agent) {
            if (strpos($userAgent, $agent) !== false) {
                $this->logSuspiciousActivity($request, 'Suspicious user agent detected: ' . $agent);
                return response('Not Found', 404);
            }
        }

        // Check for missing User-Agent header
        if (empty($userAgent)) {
            $this->logSuspiciousActivity($request, 'Missing User-Agent header');
            return response('Not Found', 404);
        }

        // Check for multiple host headers (HTTP Host header attacks)
        $hosts = $request->getHeaderLine('host');
        if (strpos($hosts, ',') !== false) {
            $this->logSuspiciousActivity($request, 'Multiple Host headers detected');
            return response('Bad Request', 400);
        }

        return $next($request);
    }

    /**
     * Log suspicious activity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reason
     * @return void
     */
    protected function logSuspiciousActivity(Request $request, string $reason): void
    {
        Log::warning('Suspicious request detected', [
            'reason' => $reason,
            'ip' => $request->ip(),
            'uri' => $request->getRequestUri(),
            'method' => $request->method(),
            'user_agent' => $request->header('User-Agent'),
            'headers' => $request->headers->all(),
        ]);
    }
}

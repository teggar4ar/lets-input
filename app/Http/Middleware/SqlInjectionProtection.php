<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SqlInjectionProtection
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
        $suspicious_inputs = [
            'select',
            'union',
            'insert',
            'update',
            'delete',
            'drop',
            'exec',
            '--',
            '/*',
            '*/',
            '@@',
            '@',
            'char',
            'nchar',
            'varchar',
            'nvarchar',
            'alter',
            'begin',
            'cast',
            'create',
            'cursor',
            'declare',
            'execute',
            'script',
            'truncate',
            'information_schema',
            'table_schema',
            'syscolumns',
            'sysobjects'
        ];

        $requestItems = $request->all();

        // Recursively check array values
        $this->checkArrayForSqlInjection($requestItems, $suspicious_inputs);

        return $next($request);
    }

    /**
     * Recursively check array for suspicious SQL injection patterns
     *
     * @param array $items
     * @param array $suspicious_inputs
     * @return void
     */
    private function checkArrayForSqlInjection(array $items, array $suspicious_inputs): void
    {
        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $this->checkArrayForSqlInjection($value, $suspicious_inputs);
            } else if (is_string($value)) {
                $lowerValue = strtolower($value);

                foreach ($suspicious_inputs as $pattern) {
                    // Check for specific SQL injection patterns with word boundaries
                    if (preg_match('/\b' . preg_quote($pattern, '/') . '\b/', $lowerValue)) {
                        abort(403, 'Potentially malicious input detected.');
                    }
                }

                // Check for typical SQL injection patterns
                if (
                    preg_match('/(\%27)|(\')|(\-\-)|(\%23)|(#)/i', $lowerValue) ||
                    preg_match('/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(\;))/i', $lowerValue) ||
                    preg_match('/\w*((\%27)|(\'))((\%6F)|o|(\%4F))((\%72)|r|(\%52))/i', $lowerValue)
                ) {
                    abort(403, 'Potentially malicious input detected.');
                }
            }
        }
    }
}

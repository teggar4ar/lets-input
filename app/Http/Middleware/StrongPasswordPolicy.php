<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StrongPasswordPolicy
{
    /**
     * The routes that should be checked for password strength.
     *
     * @var array<string>
     */
    protected $routes = [
        'register',
        'password.update',
        'profile.update',
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
        $route = $request->route();

        // Only apply to specific routes that handle passwords
        if ($route && in_array($route->getName(), $this->routes) && $request->has('password')) {
            $password = $request->input('password');
            $errors = $this->validatePasswordStrength($password);

            if (!empty($errors)) {
                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['password' => $errors]);
            }
        }

        return $next($request);
    }

    /**
     * Validate the password strength and return array of errors.
     *
     * @param  string  $password
     * @return array<string>
     */
    protected function validatePasswordStrength(string $password): array
    {
        $errors = [];

        // Check minimum length
        if (strlen($password) < 12) {
            $errors[] = 'Password must be at least 12 characters long.';
        }

        // Check for uppercase letters
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        // Check for lowercase letters
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        // Check for numbers
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        // Check for special characters
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }

        // Check for common passwords
        $commonPasswords = [
            'password',
            '123456',
            '12345678',
            'qwerty',
            'admin',
            'welcome',
            'letmein',
            'abc123',
            'monkey',
            '1234567890'
        ];

        if (in_array(strtolower($password), $commonPasswords)) {
            $errors[] = 'Password is too common and easily guessable.';
        }

        // Check for sequential characters
        if (preg_match('/(?:abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|012|123|234|345|456|567|678|789|890)/', strtolower($password))) {
            $errors[] = 'Password contains sequential characters.';
        }

        // Check for repeating characters
        if (preg_match('/(.)\1{2,}/', $password)) {
            $errors[] = 'Password contains too many repeating characters.';
        }

        return $errors;
    }
}

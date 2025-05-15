<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'secret',
        'token',
        'api_token',
        'auth_token',
        'access_token',
        'refresh_token',
        'credit_card',
        'card_number',
        'cvv',
        'social_security_number',
        'ssn',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log any additional information if needed
        });

        // Custom handler for CSRF token mismatches
        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your session has expired. Please refresh and try again.'
                ], 419);
            }

            return redirect()->back()
                ->withInput($request->except($this->dontFlash))
                ->with('error', 'Your session has expired. Please try again.');
        });

        // Custom handler for database errors to hide SQL details
        $this->renderable(function (QueryException $e, $request) {
            if (config('app.env') === 'production') {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'A database error occurred. Our team has been notified.'
                    ], 500);
                }

                return response()->view('errors.500', [], 500);
            }
        });

        // Custom handler for method not allowed errors
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The requested method is not allowed.'
                ], 405);
            }

            return response()->view('errors.404', [], 404);
        });

        // Custom handler for access denied errors
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }

            return response()->view('errors.403', [], 403);
        });

        // Generic HTTP exceptions
        $this->renderable(function (HttpException $e, $request) {
            $status = $e->getStatusCode();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'An error occurred.'
                ], $status);
            }

            if (view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [], $status);
            }

            return response()->view('errors.500', [], $status);
        });

        // Not found exceptions
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The requested resource was not found.'
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // In production, never expose exception details to the user
        if (config('app.env') === 'production' && !$this->isHttpException($e) && !($e instanceof ValidationException)) {
            // Log the real exception
            report($e);

            // Return a generic error response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An unexpected error occurred. Our team has been notified.'
                ], 500);
            }

            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }
}

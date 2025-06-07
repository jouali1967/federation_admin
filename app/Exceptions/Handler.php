<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException; // <--- ADD THIS LINE
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {

        // Prioritize catching Spatie's specific exception
        if ($exception instanceof UnauthorizedException) {
            return redirect('/');
        }

        // If it's a general AuthorizationException (e.g., from Laravel's Gates/Policies directly)
        // This line might still be hit if not caught by UnauthorizedException,
        // but putting UnauthorizedException first ensures it's handled.
        if ($exception instanceof AuthorizationException) {
            return redirect('/');
        }
        return parent::render($request, $exception);
    }
}

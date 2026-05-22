<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            return response()->view('errors.403', ['error' => $e->getMessage()], 403);
        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });
    }
}
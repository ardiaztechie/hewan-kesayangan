<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Akun yang dinonaktifkan Owner langsung dikeluarkan.
        $middleware->web(append: [
            EnsureUserIsActive::class,
        ]);

        // Pemakaian: ->middleware('role:owner') atau 'role:owner,staff'
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

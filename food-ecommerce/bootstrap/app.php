<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tin tưởng reverse proxy (nginx) để Laravel nhận đúng scheme https,
        // tránh lỗi mixed content khi chạy sau SSL termination.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );

        $middleware->validateCsrfTokens(except: [
            'webhook/payos',
        ]);

        $middleware->alias([
            'auth.custom' => \App\Http\Middleware\RedirectIfNotAuthenticated::class,
            'check.auth.admin' => \App\Http\Middleware\RedirectIfAuthenticatedAdmin::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

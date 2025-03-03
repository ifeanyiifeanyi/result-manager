<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\EnhancedVisitorLog;
use Shetabit\Visitor\Middlewares\LogVisits;
use App\Http\Middleware\RedirectBasedOnRole;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\DirectVisitorLog;
use Illuminate\Support\Facades\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            DirectVisitorLog::class,
        ]);
        $middleware->alias([
            'role' => RedirectBasedOnRole::class,
            'geoip' => DirectVisitorLog::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

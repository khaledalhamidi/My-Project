<?php

use App\Http\Middleware\CheckEmployeeRole;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // تسجيل alias
        $middleware->alias([
            'CheckEmployee' => CheckEmployeeRole::class,
            'setlocale' => SetLocale::class, // ✅ إضافة Middleware الخاص باللغة
        ]);

        // تسجيل middleware لمجموعة API
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            SubstituteBindings::class,
            'setlocale', // ✅ تأكد من إضافته هنا كـ alias وليس class مباشر
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

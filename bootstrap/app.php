<?php

use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsAdminMiddleware;
use App\Http\Middleware\PengajuanAnggaran;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => App\Http\Middleware\EnsureIsAdminMiddleware::class,
            'departement' => App\Http\Middleware\EnsureIsDepartement::class,
            'pengajuan_anggaran' => App\Http\Middleware\PengajuanAnggaran::class,
            'province' => App\Http\Middleware\EnsureIsProvince::class,
            'pusat' => App\Http\Middleware\EnsureIsPusat::class,
            'multi_role_access' => App\Http\Middleware\MultiRoleAccess::class,
            'role' => \App\Http\Middleware\EnsureHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Nouracea\Nouramework\Http\Response;
use Nouracea\Nouramework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
    Route::get('/healthcheck', function () {
        return new Response('<h1>cekaem health, good ili not good (good)</h1>');
    }),
];

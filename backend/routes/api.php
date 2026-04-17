<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoticiaApiController;

Route::middleware(['throttle:60,1'])  
    ->group(function () {
        Route::get('/noticias', [NoticiaApiController::class, 'index']);
        Route::get('/noticias/{noticia}', [NoticiaApiController::class, 'show']);
    });
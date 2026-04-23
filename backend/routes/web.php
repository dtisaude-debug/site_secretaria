<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\NoticiaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoriaController;

Route::redirect('/','/login');
// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Painel Admin (protegido por autenticação)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Notícias
    Route::resource('noticias', NoticiaController::class);
    Route::patch('noticias/{noticia}/publicar', [NoticiaController::class, 'togglePublicar'])
        ->name('noticias.publicar');

    // Usuários
    Route::resource('users', UserController::class);

    // Papéis
    Route::resource('roles', RoleController::class);

    // Categorias
    Route::resource('categorias', CategoriaController::class);
});
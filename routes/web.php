<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Wave\Facades\Wave;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Wave routes
Wave::routes();

// PWA Service Worker route
Route::get('/sw.js', function () {
    return response()->file(public_path('build/sw.js'));
});
Route::get('/workbox-{hash}.js', function ($hash) {
    return response()->file(public_path("build/workbox-{$hash}.js"));
});

// App (Inertia/React) routes
Route::middleware(['auth', 'verified'])->prefix('app')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('app.dashboard');

    Route::get('/contacts', function () {
        return Inertia::render('Contacts/Index');
    })->name('app.contacts');
});

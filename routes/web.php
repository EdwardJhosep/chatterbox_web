<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home/{mobileNumber}', [ContactoController::class, 'home'])->name('home');
Route::get('/perfil/{mobileNumber}', [ContactoController::class, 'perfil'])->name('perfil');
Route::get('/contactos/{mobileNumber}', [ContactoController::class, 'contactos'])->name('contactos');
Route::get('/estados/{mobileNumber}', [ContactoController::class, 'estados'])->name('estados');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Ruta para la página de descarga
Route::get('/download', function () {
    return view('download');
})->name('download');

Route::get('/contacto/{mobileNumber}', [ContactoController::class, 'show']);

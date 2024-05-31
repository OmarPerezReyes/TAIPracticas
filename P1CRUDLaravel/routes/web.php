<?php

// Importamos los controladores necesarios
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

// Ruta para la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el dashboard, solo accesible si el usuario está autenticado y verificado
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para la tabla estática, solo accesible si el usuario está autenticado y verificado
Route::get('/table', function () {
    return view('table');
})->middleware(['auth', 'verified'])->name('table');

// Ruta para la sección de contacto, solo accesible si el usuario está autenticado y verificado
Route::get('/contact', function () {
    return view('contact');
})->middleware(['auth', 'verified'])->name('contact');

// Grupo de rutas que solo son accesibles si el usuario está autenticado
Route::middleware('auth')->group(function () {

    // Rutas para los productos (CRUD)
    Route::resource('productos', ProductoController::class);

    // Rutas para las categorias (CRUD)
    Route::resource('categorias', CategoriaController::class);

    // Rutas para el perfil del usuario (editar, actualizar y eliminar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Importamos las rutas de autenticación
require __DIR__ . '/auth.php';

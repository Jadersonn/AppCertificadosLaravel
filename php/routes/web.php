<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', function () {
    return view('auth.home');
});
Route::get('/resetSenha', function () {
    return view('resetSenha');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/aluno', function () {
        return view('dashboard.aluno');
    })->name('dashboard.aluno');

    Route::get('/dashboard/coordenador', function () {
        return view('dashboard.coordenador');
    })->name('dashboard.coordenador');

    Route::get('/dashboard/professor', function () {
        return view('dashboard.professor');
    })->name('dashboard.professor');
});

require __DIR__ . '/auth.php';

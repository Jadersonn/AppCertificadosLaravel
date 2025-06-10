<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ProfessorController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/resetSenha', function () {
    return view('resetSenha');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

//rotas para aluno autenticado
Route::get('/aluno', function () {
    $user = Auth::user();
    return redirect()->route('aluno.show', ['numIdentidade' => $user->numIdentidade]);
})->middleware('auth')->name('aluno');

Route::middleware('auth')->group(function () {

    Route::get('/aluno/{numIdentidade}', [AlunoController::class, 'show'])->name('aluno.show');
    Route::get('/aluno/create', [AlunoController::class, 'create'])->name('aluno.create');
    Route::get('/aluno/{idnumIdentidade}/edit', [AlunoController::class, 'update'])->name('aluno.edit');
    //Route::get('/aluno/{numIdentidade}/delete', [AlunoController::class, 'destroy'])->name('aluno.delete');
});


//rotas para professor autenticado
Route::get('/professor', function () {
    $user = Auth::user();
    return redirect()->route('professor.show', ['numIdentidade' => $user->numIdentidade]);
})->middleware('auth')->name('professor');

Route::middleware('auth')->group(function () {

    Route::get('/professor/{numIdentidade}', [ProfessorController::class, 'show'])->name('professor.show');
    Route::get('/professor/create', [ProfessorController::class, 'create'])->name('professor.create');
    Route::get('/professor/{idnumIdentidade}/edit', [ProfessorController::class, 'update'])->name('professor.edit');
    //Route::get('/professor/{numIdentidade}/delete', [ProfessorController::class, 'destroy'])->name('professor.delete');
});

Route::get('/administrador', function () {
    $user = Auth::user();
    return redirect()->route('professor.showAdmin', ['numIdentidade' => $user->numIdentidade]);
})->middleware('auth')->name('administrador');

Route::middleware('auth')->group(function () {

    Route::get('/administrador/{numIdentidade}', [ProfessorController::class, 'showAdmin'])->name('professor.showAdmin');
    Route::get('/administrador/create', [ProfessorController::class, 'create'])->name('administrador.create');
    Route::get('/administrador/{idnumIdentidade}/edit', [ProfessorController::class, 'update'])->name('administrador.edit');
    //Route::get('/administrador/{numIdentidade}/delete', [ProfessorController::class, 'destroy'])->name('administrador.delete');
});


//rotas para usuario geral autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
?>
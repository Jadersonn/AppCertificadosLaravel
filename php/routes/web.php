<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AlunoController;

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
    return redirect()->route('aluno.show', ['id' => $user->numIdentidade]);
})->middleware('auth', 'verified')->name('aluno');

Route::middleware('auth')->group(function () {

    Route::get('/aluno/{numIdentidade}', [AlunoController::class, 'show'])->name('aluno.show');
    Route::get('/aluno/{numIdentidade}/delete', [AlunoController::class, 'destroy'])->name('aluno.delete');
    Route::get('/aluno/create', [AlunoController::class, 'create'])->name('aluno.create');
    Route::get('/aluno/{idnumIdentidade}/edit', [AlunoController::class, 'update'])->name('aluno.edit');
});


//rotas para usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/professor', function () {
        return view('professor');
    })->name('professor');

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');


    /*rotas para professor
    Route::get('/professor/{id}', [ProfessorController::class, 'show'])->name('professor.show');
    Route::get('/professor/{id}/delete', [ProfessorController::class, 'destroy'])->name('professor.delete');
    Route::get('/professor/create', [ProfessorController::class, 'create'])->name('professor.create');
    Route::get('/professor/{id}/edit', [ProfessorController::class, 'edit'])->name('professor.edit');
    Route::post('/professor/{id}/update', [ProfessorController::class, 'update'])->name('professor.update');

    //rotas para administrador
    Route::get('/admin/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/{id}/delete', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');*/

});

require __DIR__ . '/auth.php';
?>
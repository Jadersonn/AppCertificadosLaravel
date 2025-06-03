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

    // aponta o usuario para a rota correta com base na sua funcao
    Route::get('/redirect', function () {
        $user = auth()->user();
        if ($user->funcao === 'aluno') {
            return redirect()->route('aluno');
        } elseif ($user->funcao === 'professor') {
            return redirect()->route('professor');
        } elseif ($user->funcao === 'administrador') {
            return redirect()->route('admin');
        }
        abort(403, 'Função de usuário não reconhecida.');
    })->name('redirect');

    Route::get('/aluno', function () {
        return view('aluno');
    })->name('aluno');

    Route::get('/professor', function () {
        return view('professor');
    })->name('professor');

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');

    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    //se nao esta logado, redireciona para a pagina de login
    if (!auth()->check()) {
        return redirect('/')->with('error', 'Você precisa estar logado para acessar esta página.');
    }
});

require __DIR__ . '/auth.php';

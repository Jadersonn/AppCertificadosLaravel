<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ConclusaoController;
use App\Models\Conclusao;

Route::get('/', function () {
    //verifica se existe um usuário autenticado
    if (Auth::check()) {
        $user = Auth::user();
        //verifica se o usuário é um aluno
        if ($user->funcao === \App\Enums\FuncaoEnum::ALUNO) {
            return redirect()->route('aluno.show', ['numIdentidade' => $user->numIdentidade]);
        }
        //verifica se o usuário é um professor
        elseif ($user->funcao === \App\Enums\FuncaoEnum::PROFESSOR) {
            return redirect()->route('professor.show', ['numIdentidade' => $user->numIdentidade]);
        }
        //verifica se o usuário é um administrador
        elseif ($user->funcao === \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            return redirect()->route('professor.showAdmin', ['numIdentidade' => $user->numIdentidade]);
        }
    }
    //se não houver usuário autenticado, redireciona para a página de login
    return redirect()->route('login');
});

Route::get('/resetSenha', function () {
    return view('resetSenha');
});

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
    Route::post('/aluno/certificados', [CertificadoController::class, 'store'])->name('aluno.certificados');
    Route::post('/aluno/conclusao', [ConclusaoController::class, 'store'])->name('aluno.salvarConclusao');
    Route::get('/aluno/relatorio-categoria/{categoriaId}/{userId}', [AlunoController::class, 'relatorioCategoria'])->name('aluno.relatorioCategoria');
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

    // Aprovar certificado
    Route::post('/certificados/{id}/aprovar', [CertificadoController::class, 'aprovar'])->name('certificados.aprovar');
    // Rejeitar certificado
    Route::post('/certificados/{id}/rejeitar', [CertificadoController::class, 'rejeitar'])->name('certificados.rejeitar');
    Route::put('/certificados/{id}/atualizar', [CertificadoController::class, 'atualizar'])->name('certificados.atualizar');
    //gerar relatório de alunos
    Route::get('/professor/{numIdentidade}/relatorio', [ProfessorController::class, 'gerarRelatorio'])->name('professor.gerarRelatorio');
    //professor buscar alunos

});

Route::get('/administrador', function () {
    $user = Auth::user();
    return redirect()->route('professor.showAdmin', ['numIdentidade' => $user->numIdentidade]);
})->middleware('auth')->name('administrador');

Route::middleware('auth')->group(function () {

    Route::get('/administrador/{numIdentidade}', [ProfessorController::class, 'showAdmin'])->name('professor.showAdmin');
    Route::get('/administrador/create', [ProfessorController::class, 'create'])->name('administrador.create');
    Route::put('/administrador/{idnumIdentidade}/edit', [ProfessorController::class, 'updateAdmin'])->name('administrador.edit');
    //Route::get('/administrador/{numIdentidade}/delete', [ProfessorController::class, 'destroy'])->name('administrador.delete');

    //rotas para criar turma
    Route::get('/administrador/turma', [ProfessorController::class, 'turma'])->name('administrador.turma');
    Route::post('/administrador/criarTurma', [TurmaController::class, 'store'])->name('administrador.criarTurma');

    //rotas para definir turma
    Route::post('/administrador/definirTurma', [TurmaController::class, 'adicionarAlunos'])->name('administrador.definirTurma');

    //rotas para deletar turma
    Route::delete('/administrador/turma/{id}', [TurmaController::class, 'destroy'])->name('administrador.deletarTurma');

    //gerar relatório de alunos
    Route::get('/administrador/{numIdentidade}/relatorio', [ProfessorController::class, 'gerarRelatorio'])->name('administrador.gerarRelatorio');
});


//rotas para usuario geral autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//rotas para vizualizar certificados
Route::get('/certificados/visualizar/{id}', [CertificadoController::class, 'visualizar'])->middleware('auth');
Route::get('/buscar-aluno', [ProfessorController::class, 'buscarAluno'])->middleware('auth')->name('aluno.buscar');

Route::get('/relatorio/aluno/{numIdentidade}', [AlunoController::class, 'relatorioAluno'])->middleware('auth')->name('aluno.relatorio');
Route::post('/relatorio', [CertificadoController::class, 'gerarRelatorio'])->middleware('auth')->name('certificado.relatorio');
Route::get('/relatorio/historico/{numIdentidade}', [CertificadoController::class, 'historicoProfessor'])->middleware('auth')->name('certificado.historico');
Route::get('/relatorio/suap/{id}', [ConclusaoController::class, 'relatorioSuap'])->name('certificado.relatorioSuap');
Route::get('/relatorio/turma/{id}', [TurmaController::class, 'relatorioTurma'])->name('relatorio.turma');
require __DIR__ . '/auth.php';

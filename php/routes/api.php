<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlunoController,
    CertificadoController,
    ProfessorController,
    TurmaController,
    AtividadeComplementarController,
    TipoAtividadeController
};

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('alunos', AlunoController::class);
    Route::apiResource('professores', ProfessorController::class);
    Route::apiResource('certificados', CertificadoController::class);
    Route::apiResource('turmas', TurmaController::class);
    Route::apiResource('atividades-complementares', AtividadeComplementarController::class);
    Route::apiResource('tipos-atividade', TipoAtividadeController::class);
});

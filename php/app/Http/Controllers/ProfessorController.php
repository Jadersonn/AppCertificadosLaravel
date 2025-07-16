<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificado;

class ProfessorController extends Controller
{
    public function index()
    {
        return Professor::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        return Professor::create([
            'user_id' => $request->user_id,
        ]);
    }

    public function show($numIdentidade)
    {
        // Valida o numero de identidade
        $professor = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o professor foi encontrado
        if (!$professor) {
            abort(404, 'Professor não encontrado');
        }
        // Verifica se o usuário autenticado é professor. Se for outro tipo, impede o acesso.
        if ($professor->user->funcao !== \App\Enums\FuncaoEnum::PROFESSOR) {
            abort(403, 'Acesso não autorizado.');
        }

        $certificados = DB::select("
    SELECT users.name, turmas.nome AS turma, certificados.idAtividadeComplementar, certificados.dataEnvio, certificados.statusCertificado, certificados.caminhoArquivo, certificados.cargaHoraria, certificados.semestre
    FROM users 
    JOIN alunos ON users.id = alunos.user_id 
    JOIN turmas ON alunos.idTurma = turmas.id 
    JOIN certificados ON certificados.idAluno = alunos.idAluno
    WHERE certificados.idProfessor = ?
", [$professor->idProfessor]); // Filtro para só pegar do professor logado

        $aprovados = DB::select("SELECT users.name, alunos.dataConclusao, turmas.nome as turma FROM users join alunos on users.id = alunos.user_id join turmas on turmas.id = alunos.idTurma WHERE statusDeConclusao = 'aprovado';");
        // Retorna a view com os dados do professor e os certificados
        return view('professor.professor', compact('professor', 'certificados', 'aprovados'));
    }

    public function showAdmin($numIdentidade)
    {
        // Valida o numero de identidade
        $administrador = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o aluno foi encontrado
        if (!$administrador) {
            abort(404, 'Administrador não encontrado');
        }
        // Verifica se o usuário autenticado é administrador. Se for outro tipo, impede o acesso.
        if ($administrador->user->funcao !== \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('administrador.administrador', compact('administrador'));
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $professor->update($request->all());
        return $professor;
    }

    public function destroy($user_id)
    {
        return Professor::destroy($user_id);
    }
}

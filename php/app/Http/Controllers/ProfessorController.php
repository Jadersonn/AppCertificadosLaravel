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

        /*SELECT users.name, turmas.nome AS turma, certificados.idAtividadeComplementar, certificados.dataEnvio, certificados.statusCertificado, certificados.caminhoArquivo, certificados.cargaHoraria, certificados.semestre, certificados.idCertificado
    FROM users
    JOIN alunos ON users.id = alunos.user_id
    JOIN turmas ON alunos.idTurma = turmas.id
    JOIN certificados ON certificados.idAluno = alunos.idAluno
    WHERE certificados.statusCertificado = 'pendente' AND certificados.idProfessor = ?*/

        $certificados = DB::table('certificados')
            ->join('alunos', 'certificados.idAluno', '=', 'alunos.idAluno')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->select(
                'users.name',
                'turmas.nome as turma',
                'certificados.idAtividadeComplementar',
                'certificados.dataEnvio',
                'certificados.statusCertificado',
                'certificados.caminhoArquivo',
                'certificados.cargaHoraria',
                'certificados.semestre',
                'certificados.idCertificado'
            )
            ->where('certificados.statusCertificado', 'pendente')
            ->where('certificados.idProfessor', null) // Apenas certificados pendentes sem professor
            ->limit(8) // Limita a 10 certificados pendentes por vez
            ->orderBy('certificados.dataEnvio', 'desc')
            ->get();
        // Filtro para só pegar do professor logado

        /*        SELECT users.name, alunos.dataConclusao, turmas.nome AS turma
        FROM alunos
        JOIN users ON alunos.user_id = users.id
        JOIN turmas ON alunos.idTurma = turmas.id
        WHERE alunos.statusDeConclusao = 'aprovado'*/
        $aprovados = DB::table('alunos')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->select('users.name', 'alunos.dataConclusao', 'turmas.nome as turma')
            ->where('alunos.statusDeConclusao', 'aprovado')
            ->orderByDesc('alunos.dataConclusao')
            ->limit(5)
            ->get();

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

        $turmas = DB::table('turmas')->get();

        

        return view('administrador.administrador', compact('administrador', 'turmas'));
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

    public function buscarAluno(Request $request)
    {
        $nome = $request->input('nome');
        $turma = $request->input('turma');

        $query = DB::table('alunos')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->select(
                'users.name',
                'users.id as id_user',
                'turmas.nome as turma'
            );

        if ($nome) {
            $query->where('users.name', 'like', '%' . $nome . '%');
        }

        if ($turma) {
            $query->where('turmas.nome', 'like', '%' . $turma . '%');
        }

        $busca = $query->get();

        return view('professor.professor', compact('busca'));
    }
}

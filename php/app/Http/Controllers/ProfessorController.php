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
            'user_id' => $request->input('user_id'),
        ]);
    }

    public function show($numIdentidade)
    {
        $user = Auth::user();
        if ($user->funcao !== \App\Enums\FuncaoEnum::PROFESSOR) {
            abort(403, 'Acesso não autorizado.');
        }
        // Valida o numero de identidade
        $professor = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o professor foi encontrado
        if (!$professor) {
            abort(404, 'Professor não encontrado');
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

        $aprovados = $this->alunoAprovado();

        // Retorna a view com os dados do professor e os certificados
        return view('professor.professor', compact('professor', 'certificados', 'aprovados'));
    }

    public function alunoAprovado()
    {
        //busca os alunos aprovados
        return DB::table('alunos')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->select('users.name', 'alunos.dataConclusao as dataConclusao', 'turmas.nome as turma')
            ->where('alunos.statusDeConclusao', 'aprovado')
            ->orderByDesc('alunos.dataConclusao')
            ->limit(5)
            ->get();
    }

    public function showAdmin($numIdentidade)
    {
        $user = Auth::user();
        if ($user->funcao !== \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            abort(403, 'Acesso não autorizado.');
        }
        // Valida o numero de identidade
        $administrador = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o administrador foi encontrado
        if (!$administrador) {
            abort(404, 'Administrador não encontrado');
        }
        // Verifica se o usuário autenticado é administrador. Se for outro tipo, impede o acesso.
        if ($administrador->user->funcao !== \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            abort(403, 'Acesso não autorizado.');
        }

        $turmas = DB::table('turmas')
            ->leftJoin('alunos', 'alunos.idTurma', '=', 'turmas.id')
            ->select('turmas.id', 'turmas.nome', DB::raw('COUNT(alunos.idAluno) as totalAlunos'))
            ->groupBy('turmas.id', 'turmas.nome')
            ->orderBy('turmas.nome')
            ->get();


        //SELECT idAluno, name, numIdentidade, idTurma FROM users join alunos on alunos.user_id = users.id;
        $alunos = DB::table('users')
            ->join('alunos', 'alunos.user_id', '=', 'users.id')
            ->leftJoin('turmas', 'turmas.id', '=', 'alunos.idTurma')
            ->select(
                'alunos.idAluno',
                'users.name',
                'users.numIdentidade',
                'alunos.idTurma',
                'turmas.nome as nomeTurma'
            )
            ->get();


        // Retorna a view com os dados do professor
        $professores = Professor::join('users as U', 'U.id', '=', 'professores.user_id')
            ->select('U.name', 'U.numIdentidade', 'funcao')
            ->get();

        $aprovados = $this->alunoAprovado();
        $certificados = DB::table('certificados')
            ->join('alunos', 'certificados.idAluno', '=', 'alunos.idAluno')
            ->join('users as aluno_user', 'alunos.user_id', '=', 'aluno_user.id')
            ->leftJoin('professores', 'certificados.idProfessor', '=', 'professores.idProfessor')
            ->leftJoin('users as professor_user', 'professores.user_id', '=', 'professor_user.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->join('atividades_complementares', 'certificados.idAtividadeComplementar', '=', 'atividades_complementares.idAtividadeComplementar')
            ->join('tipos_atividades', 'atividades_complementares.idTipoAtividade', '=', 'tipos_atividades.idTipoAtividade')
            ->select([
                'aluno_user.name as aluno_nome',
                'professor_user.name as professor_nome',
                'turmas.nome as turma_nome',
                'certificados.pontosGerados as ponto',
                'tipos_atividades.nome as categoria',
                'certificados.caminhoArquivo as certificado',
                'certificados.dataEnvio',
                'certificados.cargaHoraria'
            ])
            ->orderBy('certificados.dataEnvio', 'desc')
            ->get();
        return view('administrador.administrador', compact('administrador', 'turmas', 'alunos', 'professores', 'aprovados', 'certificados'));
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
                'turmas.nome as nomeTurma'
            );

        if ($nome) {
            $query->where('users.name', 'like', '%' . $nome . '%');
        }

        if ($turma) {
            $query->where('turmas.nome', 'like', '%' . $turma . '%');
        }

        $busca = $query->get();
        $user = Auth::user();
        if ($user->funcao == \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            return view('professor.administrador', compact('busca'));
        } else {
            return view('professor.professor', compact('busca'));
        }

    }
    public function updateAdmin(Request $request, $numIdentidade)
    {
        $user = \App\Models\User::where('numIdentidade', $numIdentidade)->firstOrFail();
        $user->funcao = $request->input('nova_funcao');
        $user->save();

        return redirect()->back()->with('success', 'Função alterada com sucesso!');
    }

    public function gerarRelatorio($numIdentidade)
    {

        $user = Auth::user();
        if ($user->funcao == \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            return view('administrador.relatorio', compact('numIdentidade'));
        } else {
            return view('professor.relatorio', compact('numIdentidade'));
        }
    }
}

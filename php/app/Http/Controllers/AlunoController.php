<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\TipoAtividade;
use App\Models\AtividadeComplementar;
use App\Models\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    public function index()
    {
        return Aluno::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'dataIngresso' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'idTurma' => 'required|exists:turmas,id',
        ]);

        return Aluno::create($request->all());
    }

    public function show($numIdentidade)
    {
        // Verifica se o usuário autenticado é aluno. Se for outro tipo, impede o acesso.
        $user = Auth::user();
        if ($user->funcao !== \App\Enums\FuncaoEnum::ALUNO) {
            abort(403, 'Acesso não autorizado.');
        }
        // Valida o número de identidade
        $aluno = Aluno::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        if (!$aluno) {
            abort(404, 'Aluno não encontrado');
        }


        // Recupera todos os certificados do aluno, carregando também o relacionamento com atividadeComplementar
        $certificados = Certificado::where('idAluno', $aluno->getKey())
            ->with('atividadeComplementar')
            ->get();

        // Recupera todos os tipos de atividades complementares
        $tiposAtividades = TipoAtividade::all();
        $subCategorias = AtividadeComplementar::all();

        /*SQL 
        SELECT idTipoAtividade, sum(cargaHoraria)
    FROM users
    JOIN alunos ON users.id = alunos.user_id
    JOIN turmas ON alunos.idTurma = turmas.id
    JOIN certificados ON certificados.idAluno = alunos.idAluno
    join atividades_complementares AC on AC.idAtividadeComplementar = certificados.idAtividadeComplementar
    WHERE alunos.idAluno = ?  and statusCertificado = 'aprovado' group by AC.idTipoAtividade
        */
        $pontos = DB::table('certificados')
            ->join('alunos', 'certificados.idAluno', '=', 'alunos.idAluno')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->join('turmas', 'alunos.idTurma', '=', 'turmas.id')
            ->join('atividades_complementares as AC', 'AC.idAtividadeComplementar', '=', 'certificados.idAtividadeComplementar')
            ->where('alunos.idAluno', $aluno->getKey())
            ->where('statusCertificado', 'aprovado')
            ->select('AC.idTipoAtividade', DB::raw('SUM(cargaHoraria) as totalCargaHoraria'))
            ->groupBy('AC.idTipoAtividade')
            ->get();




        return view('aluno.aluno', compact('aluno', 'tiposAtividades', 'subCategorias', 'pontos', 'certificados'));
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());
        return $aluno;
    }

    public function destroy($id)
    {
        return Aluno::destroy($id);
    }

    public function relatorioAluno($numIdentidade)
    {
        $aluno = Aluno::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();
        if (!$aluno) {
            abort(404, 'Aluno não encontrado');
        }

        $certificados = DB::table('certificados as C')
            ->join('atividades_complementares as AC', 'AC.idAtividadeComplementar', '=', 'C.idAtividadeComplementar')
            ->join('tipos_atividades as TA', 'TA.idTipoAtividade', '=', 'AC.idTipoAtividade')
            ->leftJoin('professores as P', 'C.idProfessor', '=', 'P.idProfessor')
            ->leftJoin('users as U', 'P.user_id', '=', 'U.id')
            ->select([
                'AC.nomeAtividadeComplementar as atividade',
                'C.cargaHoraria',
                'C.pontosGerados',
                'C.dataEnvio',
                'TA.nome as categoria',
                'P.idProfessor',
                'P.user_id as professor_user_id',
                'U.name as nomeProfessor'
            ])
            ->where('C.idAluno', $aluno->idAluno)
            ->get();


        return view('relatorio.relatorioAluno', compact('aluno', 'certificados'));
    }
}

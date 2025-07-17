<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\TipoAtividade;
use App\Models\AtividadeComplementar;
use App\Models\Certificado;
use Illuminate\Http\Request;

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
            'user_id'      => 'required|exists:users,id',
            'idTurma'      => 'required|exists:turmas,id',
        ]);

        return Aluno::create($request->all());
    }

    public function show($numIdentidade)
    {
        // Valida o número de identidade
        $aluno = Aluno::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        if (!$aluno) {
            abort(404, 'Aluno não encontrado');
        }
        // Verifica se o usuário autenticado é aluno. Se for outro tipo, impede o acesso.
        if ($aluno->user->funcao !== \App\Enums\FuncaoEnum::ALUNO) {
            abort(403, 'Acesso não autorizado.');
        }
        // Recupera todos os tipos de atividades complementares
        $tiposAtividades = TipoAtividade::all();
        $subCategorias = AtividadeComplementar::all();
        
        // Recupera todos os certificados do aluno, carregando também o relacionamento com atividadeComplementar
        $certificados = Certificado::where('idAluno', $aluno->getKey())
            ->with('atividadeComplementar')
            ->get();

        // Para cada tipo, soma os pontosGerados dos certificados relacionados e calcula o percentual
        foreach ($tiposAtividades as $tipo) {
            $pontos = 0;
            foreach ($certificados as $certificado) {
                // Verifica se o certificado pertence a este tipo (via atividadeComplementar)
                if (
                    $certificado->atividadeComplementar &&
                    $certificado->atividadeComplementar->idTipoAtividade == $tipo->idTipoAtividade &&
                    $certificado->statusCertificado === 'Aprovado' 
                ) {
                    // Some os pontos gerados
                    $pontos += $certificado->pontosGerados;
                }
            }
            // Calcula o percentual (limita a 100% se ultrapassar)
            $percentual = $tipo->maximoSemestral > 0 ? min(100, ($pontos / $tipo->maximoSemestral) * 100) : 0;
            // Armazena esses valores como atributos do tipo (para uso na view)
            
            $tipo->pontosTotais = $pontos;
            $tipo->percentual = number_format($percentual, 2);
        }

        return view('aluno.aluno', compact('aluno', 'tiposAtividades', 'subCategorias', 'certificados'));
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TipoAtividade;
use App\Models\AtividadeComplementar;

class CertificadoController extends Controller
{
    public function index()
    {
        return Certificado::with(['aluno', 'atividadeComplementar', 'professor'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string',
            'subcategoria' => 'required|string',
            'semestre' => 'required|string',
            'horas' => 'required|numeric',
            'arquivo' => 'required|file|mimes:pdf|max:30720'
        ]);

        // Busca o id do aluno
        $alunoId = Aluno::getIdByUserId(Auth::user()->id);
        if (!$alunoId) {
            return redirect()->back()->withErrors(['aluno' => 'Aluno não encontrado para este usuário.']);
        }

        // Cria o certificado sem o caminho do arquivo
        $certificado = \App\Models\Certificado::create([
            'idAluno' => $alunoId,
            'idAtividadeComplementar' => $request->categoria,
            'dataEnvio' => now(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => '', // será atualizado depois
            'cargaHoraria' => $request->horas,
            'idProfessor' => null, // Será preenchido pelo professor posteriormente
            'semestre' => $request->semestre,
            'pontosGerados' => 0,
        ]);

        // Monta o nome do arquivo "idAluno-idCertificado-nomeOriginal.extensão" e retirando espacos
        $nomeOriginal = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $request->file('arquivo')->getClientOriginalName());
        $nomeArquivo = "{$alunoId}-{$certificado->idCertificado}-{$nomeOriginal}";

        // Salva o arquivo com o nome personalizado
        $path = $request->file('arquivo')->storeAs('', $nomeArquivo, 'certificados');
        if (!$path) {
            // Se falhar, apaga o certificado criado
            $certificado->delete();
            return redirect()->back()->withErrors(['arquivo' => 'Erro ao enviar o arquivo. Tente novamente.']);
        }

        // Atualiza o caminho do arquivo no certificado
        $caminhoCompleto = $path; // Salva só o caminho relativo no banco
        $certificado->update(['caminhoArquivo' => $caminhoCompleto]);

        return redirect()->back()->with('success', 'Certificado enviado com sucesso!');
    }

    public function visualizar($id)
    {
        $certificado = Certificado::findOrFail($id);
        $user = Auth::user();

        $isDono = $user->aluno && $certificado->idAluno == $user->aluno->idAluno;
        $isProfessor = $user->funcao === \App\Enums\FuncaoEnum::PROFESSOR;
        $isAdmin = $user->funcao === \App\Enums\FuncaoEnum::ADMINISTRADOR;

        if ($isDono || $isProfessor || $isAdmin) {
            $filePath = Storage::disk('certificados')->path($certificado->caminhoArquivo);

            if (!file_exists($filePath)) {
                abort(404, 'Arquivo não encontrado');
            }

            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
        }

        abort(403, 'Acesso não autorizado');
    }





    public function show($id)
    {
        return Certificado::with(['aluno', 'atividadeComplementar', 'professor'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $certificado = Certificado::findOrFail($id);
        $certificado->update($request->all());
        return $certificado;
    }

    public function destroy($id)
    {
        return Certificado::destroy($id);
    }


    public function aprovar($id)
    {
        $cert = Certificado::with('atividadeComplementar.tipoAtividade', 'aluno')->findOrFail($id);

        $alunoId = $cert->idAluno;
        $semestre = $cert->semestre;
        $pontosCertificado = $cert->cargaHoraria;

        // Verifica se aluno já aprovado
        if ($cert->aluno->statusDeConclusao === 'aprovado') {
            return back()->with('error', 'Aluno já está aprovado.');
        }

        // Dados da atividade complementar e tipo atividade
        $atividade = AtividadeComplementar::findOrFail($cert->idAtividadeComplementar);
        $tipo = TipoAtividade::findOrFail($atividade->idTipoAtividade);

        $idTipoAtividade = $tipo->idTipoAtividade;

        // Limites
        $maxSubcategoriaSemestral = $atividade->maximoSemestralAtividadeComplementar;
        $maxCategoriaCurso = $tipo->maximoCurso; // Limite padrão para subcategoria no curso

        $maxCategoriaSemestral = $tipo->maximoSemestral;
        $maxCategoriaCurso = 120; // Limite total do curso

        // Soma pontos aprovados do aluno na subcategoria naquele semestre
        info("idAluno: $alunoId, idAtividadeComplementar: {$atividade->idAtividadeComplementar}, semestre: $semestre");
        $pontosSubcategoriaSemestre = Certificado::where('idAluno', $alunoId)
            ->where('idAtividadeComplementar', $atividade->idAtividadeComplementar)
            ->where('statusCertificado', 'aprovado')
            ->where('semestre', $semestre)
            ->sum('pontosGerados');

        // Soma pontos aprovados na subcategoria no curso inteiro
        info("idAluno: $alunoId, idAtividadeComplementar: {$atividade->idAtividadeComplementar}, semestre: $semestre");
        $pontosSubcategoriaCurso = Certificado::where('idAluno', $alunoId)
            ->where('idAtividadeComplementar', $atividade->idAtividadeComplementar)
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Soma pontos aprovados na categoria naquele semestre
        info("idAluno: $alunoId, idTipoAtividade: $idTipoAtividade, semestre: $semestre");
        $pontosCategoriaSemestre = Certificado::where('idAluno', $alunoId)
            ->wherehas('atividadeComplementar', function ($query) use ($idTipoAtividade) {
                $query->where('idTipoAtividade', $idTipoAtividade);
            })
            ->where('statusCertificado', 'aprovado')
            ->where('semestre', $semestre)
            ->sum('pontosGerados');

        // Soma pontos aprovados na categoria no curso inteiro
        info("idAluno: $alunoId, idTipoAtividade: $idTipoAtividade");
        $pontosCategoriaCurso = Certificado::where('idAluno', $alunoId)
            ->whereHas('atividadeComplementar', function ($query) use ($idTipoAtividade) {
                $query->where('idTipoAtividade', $idTipoAtividade);
            })
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Soma total de pontos no curso
        $pontosTotalCurso = Certificado::where('idAluno', $alunoId)
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Log para debug
        info("Pontos Subcategoria Semestre: $pontosSubcategoriaSemestre");
        info("Pontos Subcategoria Curso: $pontosSubcategoriaCurso");
        info("Pontos Categoria Semestre: $pontosCategoriaSemestre");
        info("Pontos Categoria Curso: $pontosCategoriaCurso");
        info("Pontos Total Curso: $pontosTotalCurso");


        // Agora verifica os limites
        if ($pontosSubcategoriaSemestre >= $maxSubcategoriaSemestral) {
            info("Limite máximo da subcategoria para o semestre atingido.");
            return back()->with('error', 'Limite máximo da subcategoria para o semestre atingido.');
        } elseif ($pontosSubcategoriaSemestre + $pontosCertificado >= $maxSubcategoriaSemestral) {
            $pontosCertificado = $maxSubcategoriaSemestral - $pontosSubcategoriaSemestre;
        }

        if ($pontosSubcategoriaCurso  >= $maxCategoriaCurso) {

            info("Limite máximo da subcategoria para o curso atingido.");
            return back()->with('error', 'Limite máximo da subcategoria para o curso atingido.');
        } elseif ($pontosSubcategoriaCurso + $pontosCertificado >= $maxCategoriaCurso) {
            $pontosCertificado = $maxCategoriaCurso - $pontosSubcategoriaCurso;
        }

        if ($pontosCategoriaSemestre  >= $maxCategoriaSemestral) {

            info("Limite máximo da categoria para o semestre atingido.");
            return back()->with('error', 'Limite máximo da categoria para o semestre atingido.');
        } elseif ($pontosCategoriaSemestre + $pontosCertificado >= $maxCategoriaSemestral) {
            $pontosCertificado = $maxCategoriaSemestral - $pontosCategoriaSemestre;
        }

        if ($pontosCategoriaCurso  >= $maxCategoriaCurso) {
            info("Limite máximo da categoria para o curso atingido.");
            return back()->with('error', 'Limite máximo da categoria para o curso atingido.');
        } elseif ($pontosCategoriaCurso + $pontosCertificado >= $maxCategoriaCurso) {
            $pontosCertificado = $maxCategoriaCurso - $pontosCategoriaCurso;
        }

        if ($pontosTotalCurso >= 120) {
            info("Limite total do curso (120 pontos) atingido.");
            return back()->with('error', 'Limite total do curso (120 pontos) atingido.');
        }

        // Se passou em todas as verificações, aprova e salva
        $cert->statusCertificado = 'aprovado';
        $cert->idProfessor = Auth::id();

        // Ajusta pontos gerados para não ultrapassar 120 (se necessário)
        $limiteRestante = 120 - $pontosTotalCurso;
        $cert->pontosGerados = min($pontosCertificado, $limiteRestante);
        info("Pontos Salvos: $cert->pontosGerados");
        $cert->save();

        return back()->with('success', 'Certificado aprovado com ' . $cert->pontosGerados . ' pontos.');
    }





    public function rejeitar($id)
    {
        $cert = Certificado::findOrFail($id);
        $cert->statusCertificado = 'rejeitado';
        $cert->idProfessor = Auth::user()->id; // Define o professor que rejeitou
        $cert->save();
        return back()->with('success', 'Certificado rejeitado!');
    }

    public function edit($id)
{
    $cert = Certificado::findOrFail($id);
    $cert->idProfessor = Auth::user()->id;

    if (request()->ajax()) {
        return response()->json($cert);
    }

    return view('certificados.edit', compact('cert'));
}

}

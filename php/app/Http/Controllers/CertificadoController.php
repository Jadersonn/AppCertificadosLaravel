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
        $cert = Certificado::with('atividadeComplementar.tipoAtividade', 'aluno')
            ->findOrFail($id);

        // Pega o aluno e todos os certificados já aprovados
        $certificados = Certificado::with('atividadeComplementar.tipoAtividade')
            ->where('idAluno', $cert->idAluno)
            ->where('statusCertificado', 'aprovado')
            ->get();

        // Inicializa somas
        $porAtividade = [];
        $porTipo = [];
        $totalCurso = 0;

        foreach ($certificados as $c) {
            $atividade = $c->idAtividadeComplementar;
            $tipo = $c->atividadeComplementar->idTipoAtividade;

            $porAtividade[$atividade] = ($porAtividade[$atividade] ?? 0) + $c->pontosGerados;
            $porTipo[$tipo] = ($porTipo[$tipo] ?? 0) + $c->pontosGerados;
            $totalCurso += $c->pontosGerados;
        }

        // Informações do certificado atual
        $atividade = $cert->idAtividadeComplementar;
        $tipo = $cert->atividadeComplementar->idTipoAtividade;
        $pontos = $cert->pontosGerados;

        $limiteAtividade = $cert->atividadeComplementar->maximoSemestralAtividadeComplementar;
        $limiteTipo = $cert->atividadeComplementar->tipoAtividade->maximoSemestral;
        $limiteCurso = $cert->atividadeComplementar->tipoAtividade->maximoCurso;

        // Verifica se aprovar esse certificado ultrapassa algum limite
        if (
            ($porAtividade[$atividade] ?? 0) + $pontos <= $limiteAtividade &&
            ($porTipo[$tipo] ?? 0) + $pontos <= $limiteTipo &&
            $totalCurso + $pontos <= $limiteCurso
        ) {
            // Aprovado
            $cert->statusCertificado = 'aprovado';
            $cert->idProfessor = Auth::user()->id;
            $cert->pontosGerados += $cert->horasComplementares; // Adiciona as horas complementares ao total de pontos
            $cert->save();

            return back()->with('success', 'Certificado aprovado!');
        } else {
            // Rejeitado
            return back()->with('error', 'A aprovação deste certificado ultrapassa os limites permitidos.');
        }
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
        $cert->idProfessor = Auth::user()->id; // Define o professor que está editando
        return view('certificados.edit', compact('cert'));
    }
}


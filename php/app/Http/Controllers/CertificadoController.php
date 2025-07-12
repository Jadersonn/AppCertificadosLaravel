<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
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
            'idProfessor' => null,
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
        $caminhoCompleto = $path; // Salve só o caminho relativo no banco
        $certificado->update(['caminhoArquivo' => $caminhoCompleto]);

        return redirect()->back()->with('success', 'Certificado enviado com sucesso!');
    }

    public function visualizar($id)
    {
        $certificado = Certificado::findOrFail($id);

        $user = Auth::user();

        if (
            ($user->aluno && $certificado->idAluno == $user->aluno->idAluno) ||
            ($user->professor)
        ) {
            $file = Storage::disk('certificados')->get($certificado->caminhoArquivo);
            $nomeArquivo = basename($certificado->caminhoArquivo);

            return response($file, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $nomeArquivo . '"');
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
}

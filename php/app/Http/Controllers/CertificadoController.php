<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use Illuminate\Http\Request;

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
            'arquivo' => 'required|file|mimes:pdf|max:30720' // até 30MB
        ]);

        // Salvar o arquivo, alterar aqui para usar o sistema de arquivos do IFMS
        $path = $request->file('arquivo')->store('certificados', 'public');
        // Verifica se o upload foi bem-sucedido
        if (!$path) {
            return redirect()->back()->withErrors(['arquivo' => 'Erro ao enviar o arquivo. Tente novamente.']);
        }

        // Caminho público completo usando variável do .env
        $caminhoCompleto = env('APP_URL') . '/storage/' . $path;

        // busca o id de aluno 
        $alunoId = Aluno::getIdByUserId(Auth::user()->id);
        if (!$alunoId) {
            return redirect()->back()->withErrors(['aluno' => 'Aluno não encontrado para este usuário.']);
        }

        // Criar o certificado
        $certificado = Certificado::create([
            'idAluno' => $alunoId, // ou outro ID
            'idAtividadeComplementar' => $request->categoria, // ID da atividade complementar
            'dataEnvio' => now(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => $caminhoCompleto,
            'cargaHoraria' => $request->horas,
            'idProfessor' => null,
            'semestre' => $request->semestre,
            'pontosGerados' => 0, // Inicialmente 0, será atualizado posteriormente
        ]);

        return redirect()->back()->with('success', 'Certificado enviado com sucesso!');
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

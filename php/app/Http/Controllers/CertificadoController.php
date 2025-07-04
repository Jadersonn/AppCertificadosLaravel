<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Container\Attributes\Auth;
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

    // Salvar o arquivo
    $path = $request->file('arquivo')->store('certificados', 'public');

    // Caminho público completo usando variável do .env
    $caminhoCompleto = env('APP_URL') . '/storage/' . $path;

    // Criar o certificado
    $certificado = Certificado::create([
        'idAluno' => $request->idAluno, // ou outro ID
        'idAtividadeComplementar' => 1, // ajuste conforme sua lógica
        'dataEnvio' => now(),
        'statusCertificado' => 'pendente',
        'justificativa' => null,
        'caminhoArquivo' => $caminhoCompleto,
        'cargaHoraria' => $request->horas,
        'idProfessor' => null,
        'semestre' => $request->semestre,
        'pontosGerados' => 0, // ou sua lógica de cálculo
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


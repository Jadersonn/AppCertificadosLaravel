<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Certificado;
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
            'idAluno' => 'required|exists:alunos,id',
            'idAtividadeComplementar' => 'required|exists:atividade_complementars,id',
            'dataEnvio' => 'required|date',
            'statusCertificado' => 'required|string',
            'justificativa' => 'nullable|string',
            'caminhoArquivo' => 'required|string',
            'cargaHoraria' => 'required|numeric',
            'idProfessor' => 'nullable|exists:professors,id',
            'semestre' => 'required|string',
            'pontosGerados' => 'required|numeric',
        ]);

        return Certificado::create($request->all());
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


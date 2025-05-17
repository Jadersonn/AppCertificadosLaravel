<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idAluno' => 'required|exists:alunos,id',
            'idAtividadeComplementar' => 'required|exists:atividade_complementars,id',
            'dataEnvio' => 'required|date',
            'statusCertificado' => 'required|string',
            'justificativa' => 'nullable|string',
            'caminhoArquivo' => 'required|string',
            'cargaHoraria' => 'required|numeric',
            'idProfessor' => 'nullable|exists:professors,id',
            'semestre' => 'required|string',
        ];
    }
}

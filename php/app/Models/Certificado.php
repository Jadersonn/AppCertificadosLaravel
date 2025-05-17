<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $primaryKey = 'idCertificado';
    protected $fillable = [
        'idAluno', 'idAtividadeComplementar', 'dataEnvio',
        'statusCertificado', 'justificativa', 'caminhoArquivo',
        'cargaHoraria', 'semestre', 'idProfessor'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'idAluno');
    }

    public function atividadeComplementar()
    {
        return $this->belongsTo(AtividadeComplementar::class, 'idAtividadeComplementar');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'idProfessor');
    }
}


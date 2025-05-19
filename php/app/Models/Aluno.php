<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $primaryKey = 'idAluno';
    protected $fillable = ['dataIngresso', 'dataConclusao', 'statusDeConclusao', 'pontosRecebidos', 'idUsuario', 'idTurma'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'idTurma');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'idAluno');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

}


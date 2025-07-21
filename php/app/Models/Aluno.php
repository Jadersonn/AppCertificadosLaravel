<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $primaryKey = 'idAluno';
    protected $fillable = [
        'dataIngresso',
        'dataConclusao',
        'statusDeConclusao',
        'pontosRecebidos',
        'user_id',
        'idTurma',
    ];
    
    // busca o id do aluno pelo user_id
    public static function getIdByUserId($userId)
    {
        $aluno = self::where('user_id', $userId)->first();
        return $aluno ? $aluno->idAluno : null;
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $primaryKey = 'idUsuario';
    protected $fillable = ['nome', 'email', 'senha', 'numIdentidade', 'funcao'];

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'idUsuario');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'idUsuario');
    }
}


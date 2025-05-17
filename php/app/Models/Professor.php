<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'idProfessor';
    protected $fillable = ['idUsuario'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'idProfessor');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

}


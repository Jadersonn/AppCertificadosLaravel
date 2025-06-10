<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $table = 'professores';
    protected $primaryKey = 'idProfessor';
    protected $fillable = ['user_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'idProfessor');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}


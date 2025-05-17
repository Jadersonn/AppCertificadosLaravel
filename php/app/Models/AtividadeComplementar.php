<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeComplementar extends Model
{
    protected $primaryKey = 'idAtividadeComplementar';
    protected $fillable = ['descricaoAtividadeComplementar', 'nomeAtividadeComplementar', 'maximoSemestralAtividadeComplementar', 'idTipoAtividade'];

    public function tipo()
    {
        return $this->belongsTo(TipoAtividade::class, 'idTipoAtividade');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'idAtividadeComplementar');
    }
}


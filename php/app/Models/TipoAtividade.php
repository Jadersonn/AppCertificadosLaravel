<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  

class TipoAtividade extends Model
{
    protected $primaryKey = 'idTipoAtividade';
    protected $fillable = ['nome', 'descricao', 'maximoSemestral'];

    public function atividades()
    {
        return $this->hasMany(AtividadeComplementar::class, 'idTipoAtividade');
    }
}

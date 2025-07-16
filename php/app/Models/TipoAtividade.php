<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAtividade extends Model
{
    protected $table = 'tipos_atividades';
    protected $primaryKey = 'idTipoAtividade';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['nome', 'descricao', 'maximoSemestral'];

    public function atividades()
    {
        return $this->hasMany(AtividadeComplementar::class, 'idTipoAtividade');
    }
    public function atividadesComplementares()
    {
        return $this->hasMany(AtividadeComplementar::class, 'idTipoAtividade');
    }
}

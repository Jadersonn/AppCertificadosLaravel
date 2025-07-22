<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conclusao extends Model
{
    protected $table = 'conclusoes';

    protected $fillable = [
        'curso',
        'turno',
        'ano_ingresso',
        'ano_conclusao',
        'idAluno',
        'preenchido'
    ];

    public $timestamps = true;

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'idAluno', 'idAluno');
    }
}
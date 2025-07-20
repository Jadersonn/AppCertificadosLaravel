<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'numIdentidade',
        'funcao',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'funcao' => \App\Enums\FuncaoEnum::class,
    ];

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'user_id');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'user_id');
    }

    public static function getTipoEIdPorUserId($userId)
    {
        $user = self::find($userId);
        if (!$user) {
            return null;
        }

        // Verifica se é aluno
        $aluno = \App\Models\Aluno::where('user_id', $userId)->first();
        if ($aluno) {
            return [
                'tipo' => 'aluno',
                'id' => $aluno->input('idAluno'),
            ];
        }

        // Verifica se é professor
        $professor = \App\Models\Professor::where('user_id', $userId)->first();
        if ($professor) {
            return [
                'tipo' => 'professor',
                'id' => $professor->input('idProfessor'),
            ];
        }

        // Se não for aluno nem professor, assume administrador
        return [
            'tipo' => 'administrador',
            'id' => $userId,
        ];
    }
}

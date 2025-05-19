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
        return $this->hasOne(Aluno::class, 'idUsuario');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'idUsuario');
    }
}

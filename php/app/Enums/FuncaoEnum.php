<?php

namespace App\Enums;

enum FuncaoEnum: string
{
    case ADMINISTRADOR = 'administrador';
    case PROFESSOR = 'professor';
    case PROFESSOR_E = 'professor-E'; // Professor Especial SEM FUNCAO
    case ALUNO = 'aluno';
}


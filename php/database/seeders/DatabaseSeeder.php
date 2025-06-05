<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Turma;
use App\Models\Aluno;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria turmas de exemplo
        $turma1 = Turma::create([
            'nome' => 'Turma A',
            // adicione outros campos obrigatórios da sua tabela turmas
        ]);
        $turma2 = Turma::create([
            'nome' => 'Turma B',
            // adicione outros campos obrigatórios da sua tabela turmas
        ]);

        // Cria usuários
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('senha123'),
            'numIdentidade' => '00000000000',
            'funcao' => 'administrador',
        ]);

        $professor = User::create([
            'name' => 'Professor',
            'email' => 'professor@email.com',
            'password' => bcrypt('senha123'),
            'numIdentidade' => '11111111111',
            'funcao' => 'professor',
        ]);

        $aluno = User::create([
            'name' => 'Aluno',
            'email' => 'aluno@email.com',
            'password' => bcrypt('senha123'),
            'numIdentidade' => '22222222222',
            'funcao' => 'aluno',
        ]);

        // Cria aluno relacionado ao user e turma
        Aluno::create([
            'user_id' => $aluno->id,
            'idTurma' => $turma1->id,
            'dataIngresso' => now(),
            'dataConclusao' => null,
            'statusDeConclusao' => 'em andamento',
            'pontosRecebidos' => 0,
        ]);
    }
}

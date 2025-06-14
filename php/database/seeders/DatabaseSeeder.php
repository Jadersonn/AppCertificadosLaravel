<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\User;
use App\Models\TipoAtividade;
use App\Models\AtividadeComplementar;
use App\Models\Certificado;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria Turma(s)
        $turmaA = Turma::create([
            'nome' => 'Turma A',
        ]);

        // Cria usuários com diversas funções
        $adminUser = User::create([
            'name'          => 'Administrador',
            'email'         => 'admin@example.com',
            'password'      => Hash::make('senha123'),
            'numIdentidade' => '0000000000',
            'funcao'        => 'administrador',
        ]);

        $professorUser = User::create([
            'name'          => 'Professor',
            'email'         => 'professor@example.com',
            'password'      => Hash::make('senha123'),
            'numIdentidade' => '1111111111',
            'funcao'        => 'professor',
        ]);

        $alunoUser = User::create([
            'name'          => 'Aluno',
            'email'         => 'aluno@example.com',
            'password'      => Hash::make('senha123'),
            'numIdentidade' => '2222222222',
            'funcao'        => 'aluno',
        ]);

        // Relaciona os usuários com suas respectivas entidades
        $professor = Professor::create([
            'user_id' => $professorUser->getKey(),
        ]);

        $administrador = Professor::create([
            'user_id' => $adminUser->getKey(),
        ]);

        $aluno = Aluno::create([
            'user_id'           => $alunoUser->getKey(),
            'idTurma'           => $turmaA->id,
            'dataIngresso'      => Carbon::now(),
            'dataConclusao'     => null,
            'statusDeConclusao' => 'em andamento',
            'pontosRecebidos'   => 0,
        ]);

        // Cria Tipos de Atividades utilizando os valores dinamicamente
        $tipoEnsino = TipoAtividade::create([
            'nome'            => 'Ensino',
            'descricao'       => 'Atividades relacionadas ao ensino',
            'maximoSemestral' => 40,
        ]);

        $tipoPesquisa = TipoAtividade::create([
            'nome'            => 'Pesquisa',
            'descricao'       => 'Atividades relacionadas à pesquisa',
            'maximoSemestral' => 30,
        ]);

        $tipoExtensao = TipoAtividade::create([
            'nome'            => 'Extensão',
            'descricao'       => 'Atividades de extensão',
            'maximoSemestral' => 20,
        ]);

        // Cria Atividade Complementar utilizando o ID retornado dinamicamente do $tipoEnsino
        $atividadeComplementar = AtividadeComplementar::create([
            'nomeAtividadeComplementar'             => 'Palestra',
            'descricaoAtividadeComplementar'          => 'Participação em palestra',
            'maximoSemestralAtividadeComplementar'    => 5,
            'idTipoAtividade'                         => $tipoEnsino->getKey(),
        ]);

        Certificado::create([
            'idAluno'                 => $aluno->getKey(),
            'idAtividadeComplementar' => $atividadeComplementar->getKey(),
            'dataEnvio'               => Carbon::now()->toDateString(),
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 5,
            'semestre'                => '2025-1',
            'idProfessor'             => $professor->getKey(),
            'pontosGerados'           => 10,
        ]);
    }
}

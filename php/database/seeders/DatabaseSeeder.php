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
        // Criação de Turmas, Usuários, TipoAtividade, etc. (você já deve ter estes inserts)
        // Exemplo:
        $turmaA = Turma::create(['nome' => 'Turma A']);
        
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
        
        $professor = Professor::create(['user_id' => $professorUser->id]);
        
        $aluno = Aluno::create([
            'user_id'           => $alunoUser->id,
            'idTurma'           => $turmaA->id,
            'dataIngresso'      => Carbon::now(),
            'dataConclusao'     => null,
            'statusDeConclusao' => 'em andamento',
            'pontosRecebidos'   => 0,
        ]);
        
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
        
        // Certifique-se de criar as AtividadesComplementares que serão referenciadas nos certificados
        $atividade1 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Palestra',
            'descricaoAtividadeComplementar'       => 'Participação em palestra',
            'maximoSemestralAtividadeComplementar' => 5,
            'idTipoAtividade'                      => $tipoEnsino->getKey(), 
        ]);
        
        $atividade2 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Pesquisa Avançada',
            'descricaoAtividadeComplementar'       => 'Pesquisa em laboratório',
            'maximoSemestralAtividadeComplementar' => 10,
            'idTipoAtividade'                      => $tipoPesquisa->getKey(),
        ]);

        Certificado::create([
            'idAluno'                 => 2, // idAluno = 2
            'idAtividadeComplementar' => 1, // considerando que atividade1 recebeu id 1
            'dataEnvio'               => '2025-06-14',
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 5,
            'semestre'                => '2025-1',
            'idProfessor'             => 1,
            'pontoGerados'            => 10,
            'created_at'              => Carbon::parse('2025-06-14 22:13:23'),
            'updated_at'              => Carbon::parse('2025-06-14 22:13:23'),
        ]);
        
        // Registro 2:
        Certificado::create([
            'idAluno'                 => 1, // idAluno = 1
            'idAtividadeComplementar' => 1,
            'dataEnvio'               => '2025-06-14',
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 25,
            'semestre'                => '2025-1',
            'idProfessor'             => 1,
            'pontoGerados'            => 38,
            'created_at'              => Carbon::parse('2025-06-14 21:57:54'),
            'updated_at'              => Carbon::parse('2025-06-14 21:57:54'),
        ]);
        
        // Registro 3:
        Certificado::create([
            'idAluno'                 => 1,
            'idAtividadeComplementar' => 1,
            'dataEnvio'               => '2025-06-14',
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 25,
            'semestre'                => '2025-1',
            'idProfessor'             => 1,
            'pontoGerados'            => 2,
            'created_at'              => Carbon::parse('2025-06-14 21:57:54'),
            'updated_at'              => Carbon::parse('2025-06-14 21:57:54'),
        ]);
        
        // Registro 4:
        Certificado::create([
            'idAluno'                 => 1,
            'idAtividadeComplementar' => 2, // usando a atividade2
            'dataEnvio'               => '2025-06-14',
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 25,
            'semestre'                => '2025-1',
            'idProfessor'             => 1,
            'pontoGerados'            => 20,
            'created_at'              => Carbon::parse('2025-06-14 21:57:54'),
            'updated_at'              => Carbon::parse('2025-06-14 21:57:54'),
        ]);
        
    }
}

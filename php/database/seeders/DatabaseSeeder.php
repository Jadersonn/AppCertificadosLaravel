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
            'idTurma'           => $turmaA->getKey(),
            'dataIngresso'      => Carbon::now(),
            'dataConclusao'     => null,
            'statusDeConclusao' => 'em andamento',
            'pontosRecebidos'   => 0,
        ]);

        // Cria Tipos de Atividades utilizando os valores dinamicamente
        $enriquecimentoCultural = TipoAtividade::create([
            'nome'            => 'Enriquecimento Cultural',
            'descricao'       => 'Atividades de aperfeiçoamento e enriquecimento cultural e esportivo',
            'maximoSemestral' => 80,
            'maximoCurso'    => 120,
        ]);

        $docencia = TipoAtividade::create([
            'nome'            => 'Docência',
            'descricao'       => 'Atividades de divulgação científica e de iniciação à docência',
            'maximoSemestral' => 60,
            'maximoCurso'    => 100,
        ]);

        $vivenciaAcademica = TipoAtividade::create([
            'nome'            => 'Vivência Acadêmica',
            'descricao'       => 'Atividades de vivência acadêmica e profissional complementar',
            'maximoSemestral' => 60,
            'maximoCurso'    => 100,
        ]);

        $pesquisaExtensao = TipoAtividade::create([
            'nome'            => 'Pesquisa ou Extensão',
            'descricao'       => 'Atividades de Pesquisa ou Extensão e publicações',
            'maximoSemestral' => 80,
            'maximoCurso'    => 100,
        ]);

        // Cria Atividade Complementar utilizando o ID retornado dinamicamente do $tipoEnsino
        /*
        MODELO:
        $ = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => '',
            'descricaoAtividadeComplementar'       =>  '',
            'maximoSemestralAtividadeComplementar' => ,
            'idTipoAtividade'                      => $->getKey(),
        ]);

        */
        $enriquecimento_atividade1 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'             => 'Participação como agente',
            'descricaoAtividadeComplementar'        => 'Participação como agente em atividades culturais: filme, teatro, apresentações artísticas, feiras, exposições, festivais e competições esportivas, bandas, coral, olimpíadas em geral.',
            'maximoSemestralAtividadeComplementar'  => 30,
            'idTipoAtividade'                       => $enriquecimentoCultural->getKey(),
        ]);

        $enriquecimento_atividade2 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Pesquisa Avançada',
            'descricaoAtividadeComplementar'       =>  'Visitas técnicas e culturais: patrimônios tombados, cidades históricas, monumentos, museus, memoriais, escola-modelo, creches, berçários, ONGs, APAE e entidades afins, hospitais laboratórios, instituições de ensino e pesquisa, empresas públicas e privadas e outras de interesse do curso.',
            'maximoSemestralAtividadeComplementar' => 30,
            'idTipoAtividade'                      => $enriquecimentoCultural->getKey(),
        ]);
        $enriquecimento_atividade3 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Cursos',
            'descricaoAtividadeComplementar'       =>  'Realização de cursos de língua estrangeira, informática e outros de formação cultural, social ou específica do âmbito do curso.',
            'maximoSemestralAtividadeComplementar' => 40,
            'idTipoAtividade'                      => $enriquecimentoCultural->getKey(),
        ]);

        $enriquecimento_atividade4 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Trabalho Voluntário',
            'descricaoAtividadeComplementar'       =>  'Trabalho voluntário, atividades comunitárias, associações de bairros, brigadas de incêndio e associações escolares.',
            'maximoSemestralAtividadeComplementar' => 40,
            'idTipoAtividade'                      => $enriquecimentoCultural->getKey(),
        ]);

        //ativiades de docência
        $docencia_atividade1 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Monitoria',
            'descricaoAtividadeComplementar'       =>  'Monitoria remunerada ou voluntária',
            'maximoSemestralAtividadeComplementar' => 60,
            'idTipoAtividade'                      => $docencia->getKey(),
        ]);

        $docencia_atividade2 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Atividades Técnico-Científicas',
            'descricaoAtividadeComplementar'       =>  'Membro atuante em atividades técnico- científicas, tais como apresentação de trabalhos científicos, ministrar palestras, orientações técnicas supervisionadas e participação em bancas de debate.',
            'maximoSemestralAtividadeComplementar' => 30,
            'idTipoAtividade'                      => $docencia->getKey(),
        ]);

        $docencia_atividade3 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação em Atividades Pedagógicas',
            'descricaoAtividadeComplementar'       =>  'Participação em atividades pedagógicas de observação.',
            'maximoSemestralAtividadeComplementar' => 20,
            'idTipoAtividade'                      => $docencia->getKey(),
        ]);

        //atividades de vivência acadêmica
        $vivencia_atividade1 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Organização de Eventos',
            'descricaoAtividadeComplementar'       =>  'Organização de eventos acadêmicos e festivais.',
            'maximoSemestralAtividadeComplementar' => 30,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);

        $vivencia_atividade2 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Representação Estudantil',
            'descricaoAtividadeComplementar'       =>  'Representação discente em Conselhos e Entidades estudantis, liderança de turma, órgãos de classe e conselhos representativos.',
            'maximoSemestralAtividadeComplementar' => 20,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);
        $vivencia_atividade3 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação como ouvinte em Eventos Acadêmicos',
            'descricaoAtividadeComplementar'       =>  'Participação como ouvinte em eventos acadêmicos, tais como bancas de TCC, dissertação, teses.',
            'maximoSemestralAtividadeComplementar' => 18,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);
        $vivencia_atividade4 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação como ouvinte em eventos relacionados ao curso',
            'descricaoAtividadeComplementar'       =>  'Participação como ouvinte em congressos, seminários, simpósios e demais eventos relacionados ao curso de graduação ou áreas afins.',
            'maximoSemestralAtividadeComplementar' => 40,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);
        $vivencia_atividade5 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação como ouvinte em Visitas Técnicas',
            'descricaoAtividadeComplementar'       =>  'Participação em visita técnica relacionada à área de atuação.',
            'maximoSemestralAtividadeComplementar' => 20,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);
        $vivencia_atividade6 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação em projetos de incubação',
            'descricaoAtividadeComplementar'       =>  'Participação em projetos de incubação.',
            'maximoSemestralAtividadeComplementar' => 45,
            'idTipoAtividade'                      => $vivenciaAcademica->getKey(),
        ]);

        //atividades de pesquisa e extensão
        $pesquisa_atividade1 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação em Projetos de Pesquisa',
            'descricaoAtividadeComplementar'       =>  'Participação em projetos e grupos de pesquisa',
            'maximoSemestralAtividadeComplementar' => 45,
            'idTipoAtividade'                      => $pesquisaExtensao->getKey(),
        ]);

        $pesquisa_atividade2 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Participação em Projetos de Extensão',
            'descricaoAtividadeComplementar'       =>  'Participação em projetos e grupos de extensão',
            'maximoSemestralAtividadeComplementar' => 45,
            'idTipoAtividade'                      => $pesquisaExtensao->getKey(),
        ]);

        $pesquisa_atividade3 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Publicação de Artigo Científico',
            'descricaoAtividadeComplementar'       =>  'Publicação de artigo científico completo em revista ou periódico',
            'maximoSemestralAtividadeComplementar' => 50,
            'idTipoAtividade'                      => $pesquisaExtensao->getKey(),
        ]);

        $pesquisa_atividade4 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Publicação de Resumo de Artigo Científico',
            'descricaoAtividadeComplementar'       =>  'Publicação de resumos de artigo científico em revista ou periódico',
            'maximoSemestralAtividadeComplementar' => 50,
            'idTipoAtividade'                      => $pesquisaExtensao->getKey(),
        ]);

        $pesquisa_atividade5 = AtividadeComplementar::create([
            'nomeAtividadeComplementar'          => 'Publicação de Matéria ou Nota',
            'descricaoAtividadeComplementar'       =>  'Publicação de matérias ou notas em jornais e meios eletrônicos',
            'maximoSemestralAtividadeComplementar' => 10,
            'idTipoAtividade'                      => $pesquisaExtensao->getKey(),
        ]);

        Certificado::create([
            'idAluno'                 => $aluno->getKey(),
            'idAtividadeComplementar' => $enriquecimento_atividade1->getKey(),
            'dataEnvio'               => Carbon::now()->toDateString(),
            'statusCertificado'       => 'pendente',
            'justificativa'           => null,
            'caminhoArquivo'          => 'certificados/palestra.pdf',
            'cargaHoraria'            => 5,
            'semestre'                => '2025-1',
            'idProfessor'             => null,
            'pontosGerados'           => 10,
        ]);

                Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $enriquecimento_atividade2->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/visita_tecnica.pdf',
            'cargaHoraria' => 10,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 15,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $docencia_atividade1->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/monitoria.pdf',
            'cargaHoraria' => 20,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 25,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade1->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'aprovado',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/evento.pdf',
            'cargaHoraria' => 15,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 15,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade2->getKey(),
            'dataEnvio' => Carbon::now()->subDays(5)->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/lideranca.pdf',
            'cargaHoraria' => 5,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 8,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $pesquisa_atividade1->getKey(),
            'dataEnvio' => Carbon::now()->subDays(10)->toDateString(),
            'statusCertificado' => 'aprovado',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/pesquisa.pdf',
            'cargaHoraria' => 30,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 35,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $docencia_atividade2->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/palestra.pdf',
            'cargaHoraria' => 12,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 20,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade3->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'rejeitado',
            'justificativa' => 'Carga horária incompatível com o evento.',
            'caminhoArquivo' => 'certificados/banca_tcc.pdf',
            'cargaHoraria' => 8,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 0,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $pesquisa_atividade3->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/artigo.pdf',
            'cargaHoraria' => 25,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 40,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade4->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/congresso.pdf',
            'cargaHoraria' => 15,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 20,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $pesquisa_atividade4->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'aprovado',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/resumo_artigo.pdf',
            'cargaHoraria' => 20,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 30,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade5->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/visita_area.pdf',
            'cargaHoraria' => 12,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 15,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $vivencia_atividade6->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/incubacao.pdf',
            'cargaHoraria' => 18,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 22,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $pesquisa_atividade5->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/materia_jornal.pdf',
            'cargaHoraria' => 8,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 10,
        ]);

        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $docencia_atividade3->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/pedagogica.pdf',
            'cargaHoraria' => 10,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 12,
        ]);
        Certificado::create([
            'idAluno' => $aluno->getKey(),
            'idAtividadeComplementar' => $enriquecimento_atividade3->getKey(),
            'dataEnvio' => Carbon::now()->toDateString(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => 'certificados/curso_lingua.pdf',
            'cargaHoraria' => 20,
            'semestre' => '2025-1',
            'idProfessor' => null,
            'pontosGerados' => 25,
        ]);

    }
}

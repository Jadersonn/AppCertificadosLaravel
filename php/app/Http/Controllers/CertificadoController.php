<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TipoAtividade;
use App\Models\AtividadeComplementar;
use App\Enums\FuncaoEnum;
use App\Models\Professor;
use Illuminate\Support\Facades\DB;

class CertificadoController extends Controller
{
    public function index()
    {
        return Certificado::with(['aluno', 'atividadeComplementar', 'professor'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string',
            'subcategoria' => 'required|string',
            'semestre' => 'required|string',
            'horas' => 'required|numeric',
            'arquivo' => 'required|file|mimes:pdf|max:30720'
        ]);

        // Busca o id do aluno
        $alunoId = Aluno::getIdByUserId(Auth::user()->id);
        if (!$alunoId) {
            return redirect()->back()->withErrors(['aluno' => 'Aluno não encontrado para este usuário.']);
        }

        // Cria o certificado sem o caminho do arquivo
        $certificado = Certificado::create([
            'idAluno' => $alunoId,
            'idAtividadeComplementar' => $request->categoria,
            'dataEnvio' => now(),
            'statusCertificado' => 'pendente',
            'justificativa' => null,
            'caminhoArquivo' => '', // será atualizado depois
            'cargaHoraria' => $request->horas,
            'idProfessor' => null, // Será preenchido pelo professor posteriormente
            'semestre' => $request->semestre,
            'pontosGerados' => 0,
        ]);

        // Monta o nome do arquivo "idAluno-idCertificado-nomeOriginal.extensão" e retirando espacos
        $nomeOriginal = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $request->file('arquivo')->getClientOriginalName());
        $nomeArquivo = "{$alunoId}-{$certificado->idCertificado}-{$nomeOriginal}";

        // Salva o arquivo com o nome personalizado
        $path = $request->file('arquivo')->storeAs('', $nomeArquivo, 'certificados');
        if (!$path) {
            // Se falhar, apaga o certificado criado
            $certificado->delete();
            return redirect()->back()->withErrors(['arquivo' => 'Erro ao enviar o arquivo. Tente novamente.']);
        }

        // Atualiza o caminho do arquivo no certificado
        $caminhoCompleto = $path; // Salva só o caminho relativo no banco
        $certificado->update(['caminhoArquivo' => $caminhoCompleto]);

        return redirect()->back()->with('success', 'Certificado enviado com sucesso!');
    }

    public function visualizar($id)
    {
        $certificado = Certificado::findOrFail($id);
        $user = Auth::user();

        $isDono = $user->aluno && $certificado->idAluno == $user->aluno->idAluno;
        $isProfessor = $user->funcao === FuncaoEnum::PROFESSOR;
        $isAdmin = $user->funcao === FuncaoEnum::ADMINISTRADOR;

        if ($isDono || $isProfessor || $isAdmin) {
            $filePath = Storage::disk('certificados')->path($certificado->caminhoArquivo);

            if (!file_exists($filePath)) {
                abort(404, 'Arquivo não encontrado');
            }

            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
        }

        abort(403, 'Acesso não autorizado');
    }





    public function show($id)
    {
        return Certificado::with(['aluno', 'atividadeComplementar', 'professor'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $certificado = Certificado::findOrFail($id);
        $certificado->update($request->all());
        return $certificado;
    }

    public function destroy($id)
    {
        return Certificado::destroy($id);
    }


    public function aprovar($id)
    {
        //info("Aprovando certificado...");
        $cert = Certificado::findOrFail($id);

        $alunoId = $cert->idAluno;
        $semestre = $cert->semestre;
        //busca indice da atividade complementar
        $indiceAtividade = AtividadeComplementar::findOrFail($cert->idAtividadeComplementar)->indice;
        //info("Índice da Atividade: $indiceAtividade");
        // Calcula os pontos de acordo com a lógica definida
        $pontosCertificado = $this->logicaPonto($indiceAtividade, $cert->cargaHoraria);
        // Verifica se aluno já aprovado
        if ($cert->aluno->statusDeConclusao === 'aprovado') {
            $cert->statusCertificado = 'rejeitado';
            $cert->idProfessor = Auth::id();
            $cert->justificativa = 'Aluno já aprovado.';
            $cert->updated_at = now();
            $cert->save();
            return back()->with('success', 'Aluno já está aprovado.');
        } else {
            //info("Aluno não aprovado, continuando com a aprovação do certificado...");
        }

        // Dados da atividade complementar e tipo atividade
        $atividade = AtividadeComplementar::findOrFail($cert->idAtividadeComplementar);
        $tipo = TipoAtividade::findOrFail($atividade->idTipoAtividade);

        $idTipoAtividade = $tipo->idTipoAtividade;

        // Limites
        $maxSubcategoriaSemestral = $atividade->maximoSemestralAtividadeComplementar;
        $maxCategoriaCurso = $tipo->maximoCurso; // Limite padrão para subcategoria no curso

        $maxCategoriaSemestral = $tipo->maximoSemestral;
        $maxCategoriaCurso = 120; // Limite total do curso

        // Soma pontos aprovados do aluno na subcategoria naquele semestre
        //info("idAluno: $alunoId, idAtividadeComplementar: {$atividade->idAtividadeComplementar}, semestre: $semestre");
        $pontosSubcategoriaSemestre = Certificado::where('idAluno', $alunoId)
            ->where('idAtividadeComplementar', $atividade->idAtividadeComplementar)
            ->where('statusCertificado', 'aprovado')
            ->where('semestre', $semestre)
            ->sum('pontosGerados');

        // Soma pontos aprovados na subcategoria no curso inteiro
        //info("idAluno: $alunoId, idAtividadeComplementar: {$atividade->idAtividadeComplementar}, semestre: $semestre");
        $pontosSubcategoriaCurso = Certificado::where('idAluno', $alunoId)
            ->where('idAtividadeComplementar', $atividade->idAtividadeComplementar)
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Soma pontos aprovados na categoria naquele semestre
        //info("idAluno: $alunoId, idTipoAtividade: $idTipoAtividade, semestre: $semestre");
        $pontosCategoriaSemestre = Certificado::where('idAluno', $alunoId)
            ->wherehas('atividadeComplementar', function ($query) use ($idTipoAtividade) {
                $query->where('idTipoAtividade', $idTipoAtividade);
            })
            ->where('statusCertificado', 'aprovado')
            ->where('semestre', $semestre)
            ->sum('pontosGerados');

        // Soma pontos aprovados na categoria no curso inteiro
        //info("idAluno: $alunoId, idTipoAtividade: $idTipoAtividade");
        $pontosCategoriaCurso = Certificado::where('idAluno', $alunoId)
            ->whereHas('atividadeComplementar', function ($query) use ($idTipoAtividade) {
                $query->where('idTipoAtividade', $idTipoAtividade);
            })
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Soma total de pontos no curso
        $pontosTotalCurso = Certificado::where('idAluno', $alunoId)
            ->where('statusCertificado', 'aprovado')
            ->sum('pontosGerados');

        // Log para debug
        //info("Pontos Subcategoria Semestre: $pontosSubcategoriaSemestre");
        //info("Pontos Subcategoria Curso: $pontosSubcategoriaCurso");
        //info("Pontos Categoria Semestre: $pontosCategoriaSemestre");
        //info("Pontos Categoria Curso: $pontosCategoriaCurso");
        //info("Pontos Total Curso: $pontosTotalCurso");


        // Agora verifica os limites
        if ($pontosSubcategoriaSemestre >= $maxSubcategoriaSemestral) {
            //info("Limite máximo da subcategoria para o semestre atingido.");
            $cert->updated_at = now();
            $cert->save();
            return back()->with('error', 'Limite máximo da subcategoria para o semestre atingido. Caso valido realoque para outro semestre.');
        } elseif ($pontosSubcategoriaSemestre + $pontosCertificado >= $maxSubcategoriaSemestral) {
            $pontosCertificado = $maxSubcategoriaSemestral - $pontosSubcategoriaSemestre;
        }

        if ($pontosSubcategoriaCurso  >= $maxCategoriaCurso) {

            //info("Limite máximo da subcategoria para o curso atingido.");
            $cert->updated_at = now();
            $cert->save();
            return back()->with('error', 'Limite máximo da subcategoria para o curso atingido. Caso valido realoque para outra subcategoria.');
        } elseif ($pontosSubcategoriaCurso + $pontosCertificado >= $maxCategoriaCurso) {
            $pontosCertificado = $maxCategoriaCurso - $pontosSubcategoriaCurso;
        }

        if ($pontosCategoriaSemestre  >= $maxCategoriaSemestral) {

            //info("Limite máximo da categoria para o semestre atingido.");
            $cert->updated_at = now();
            $cert->save();
            return back()->with('error', 'Limite máximo da categoria para o semestre atingido. Caso válido, realoque o semestre.');
        } elseif ($pontosCategoriaSemestre + $pontosCertificado >= $maxCategoriaSemestral) {
            $pontosCertificado = $maxCategoriaSemestral - $pontosCategoriaSemestre;
        }

        if ($pontosCategoriaCurso  >= $maxCategoriaCurso) {
            //info("Limite máximo da categoria para o curso atingido.");
            $cert->updated_at = now();
            $cert->save();
            return back()->with('error', 'Limite máximo da categoria para o curso atingido. Caso válido, realoque a categoria e sua subcategoria.');
        } elseif ($pontosCategoriaCurso + $pontosCertificado >= $maxCategoriaCurso) {
            $pontosCertificado = $maxCategoriaCurso - $pontosCategoriaCurso;
        }

        // Se passou em todas as verificações, aprova e salva
        $cert->statusCertificado = 'aprovado';
        $cert->idProfessor = Professor::getIdByUserId(Auth::user()->id);

        // Ajusta pontos gerados para não ultrapassar 120 (se necessário)
        $limiteRestante = 120 - $pontosTotalCurso;

        if ($pontosCertificado == 0) {
            //se os pontos do certificado forem 0, reprova o certificado
            $cert->statusCertificado = 'pendente';
            $cert->justificativa = 'Certificado não atendeu aos critérios para pontuação.';
            $cert->updated_at = now();
            $cert->save();
            return back()->with('error', 'Certificado não atendeu aos critérios para pontuação nessa subcategoria, caso válido, realoque.');
        }
        if ($limiteRestante == 0) {
            // Atualiza os pontos do aluno
            $aluno = Aluno::findOrFail($alunoId);
            $aluno->dataConclusao = now();
            $aluno->statusDeConclusao = 'aprovado';
            $aluno->updated_at = now();
            $aluno->save();
            return back()->with('success', 'Aluno aprovado: ' . $aluno->pontosRecebidos . ' pontos.');
        }

        $cert->pontosGerados = min($pontosCertificado, $limiteRestante);
        //info("Pontos Salvos: $cert->pontosGerados");
        //info("");
        $cert->justificativa = 'Aprovado pelo professor ' . Auth::user()->name;
        $cert->updated_at = now();
        $cert->save();

        // Atualiza os pontos do aluno
        $aluno = Aluno::findOrFail($alunoId);
        $aluno->pontosRecebidos += $cert->pontosGerados;
        $aluno->updated_at = now();
        $aluno->save();

        return back()->with('success', 'Certificado aprovado com ' . $cert->pontosGerados . ' pontos.');
    }

    function logicaPonto($indice, $pontos)
    {
        switch ($indice) {
            case 1.1:
                return 5; // 5 pontos por atividade
            case 1.2:
                return 5; // 5 pontos por visita
            case 1.3:
                return $pontos; // 1 ponto por hora
            case 1.4:
                return 10; // 10 pontos por documento
            case 2.1:
                return 15; // 15 pontos por participação
            case 2.2:
                return 10; // 10 pontos por participação
            case 2.3:
                return 5; // 5 pontos por participação
            case 3.1:
                return $pontos; // 1 ponto por hora
            case 3.2:
                return 5; // 5 pontos por participação
            case 3.3:
                return 3; // 3 pontos por participação
            case 3.4:
                return $pontos; // 1 ponto por hora
            case 3.5:
                return $pontos; // 1 ponto por hora
            case 3.6:
                return $pontos * 7.5; // 7,5 pontos por mês
            case 4.1:
                return $pontos * 7.5; // 7,5 pontos por mês
            case 4.2:
                return $pontos * 7.5; // 7,5 pontos por mês
            case 4.3:
                return 25; // 25 pontos por publicação
            case 4.4:
                return 15; // 15 pontos por publicação
            case 4.5:
                return 5; // 5 pontos por publicação
            default:
                return $pontos; // Caso não tenha correspondência, retorna o próprio valor
        }
    }





    public function rejeitar(Request $request, $id)
    {
        $cert = Certificado::findOrFail($id);
        $cert->statusCertificado = 'rejeitado';
        $cert->idProfessor = Auth::user()->id; // Define o professor que rejeitou
        $cert->justificativa = $request->input('justificativa'); // Salva a justificativa enviada
        $cert->updated_at = now(); // Atualiza o timestamp
        $cert->save();
        return back()->with('success', 'Certificado rejeitado!');
    }

    public function edit($id)
    {
        $cert = Certificado::findOrFail($id);
        $cert->idProfessor = Auth::user()->id;

        if (request()->ajax()) {
            return response()->json($cert);
        }

        return view('certificados.edit', compact('cert'));
    }

    public function historicoProfessor($numIdentidade)
    {
        $professor = DB::table('professores')
            ->join('users', 'users.id', '=', 'professores.user_id')
            ->where('users.numIdentidade', $numIdentidade)
            ->select('professores.*', 'users.*') // ou apenas os campos desejados
            ->first();

        if (!$professor) {
            return redirect()->back()->withErrors(['professor' => 'Professor não encontrado.']);
        }

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->where('c.idProfessor', $professor->idProfessor)
            ->select(
                'u.name',
                't.nome',
                'c.statusCertificado',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->get();

        return view('relatorio.relatorioProfessor', compact('professor', 'certificados'));
    }
    public function gerarRelatorio(Request $request)
    {
        // Validação dos campos obrigatórios
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'ordem' => 'required|in:turma,professor,aprovados,pontos,horas,recusados',
        ]);

        // Recupera a opção selecionada
        $ordem = $request->input('ordem');

        // Switch para tratar cada opção
        switch ($ordem) {
            case 'turma':
                return $this->relatorioPorTurma($request);
            case 'professor':
                return $this->relatorioPorProfessor($request);
            case 'aprovados':
                return $this->relatorioAprovados($request);
            case 'pontos':
                return $this->relatorioRecebidos($request);
            case 'horas':
                return $this->relatorioHoras($request);
            case 'recusados':
                return $this->relatorioRecusados($request);
            default:
                return redirect()->back(); // ou uma página de erro
        }
    }

    public function relatorioRecusados(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('professores as p', 'c.idProfessor', '=', 'p.idProfessor')
            ->leftJoin('users as up', 'up.id', '=', 'p.user_id') // Nome do professor
            ->where('c.statusCertificado', '=', 'rejeitado')
            ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]) // <-- Filtro de período
            ->select(
                'c.idCertificado',
                'u.name as aluno',
                't.nome as turma',
                'up.name as professor',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->orderBy('c.dataEnvio', 'desc')
            ->get();
        return view('relatorio.relatorioCertificados', compact('certificados'));
    }
    public function relatorioHoras(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('professores as p', 'c.idProfessor', '=', 'p.idProfessor')
            ->leftJoin('users as up', 'up.id', '=', 'p.user_id') // Nome do professor
            ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]) // <-- Filtro de período
            ->select(
                'c.idCertificado',
                'u.name as aluno',
                't.nome as turma',
                'up.name as professor',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->orderBy('c.cargaHoraria', 'desc')
            ->get();
        return view('relatorio.relatorioCertificados', compact('certificados'));
    }
    public function relatorioRecebidos(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('professores as p', 'c.idProfessor', '=', 'p.idProfessor')
            ->leftJoin('users as up', 'up.id', '=', 'p.user_id') // Nome do professor
            ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]) // <-- Filtro de período
            ->where('c.pontosGerados', '>', 0) // <-- Evita mostrar pontos = 0
            ->select(
                'c.idCertificado',
                'u.name as aluno',
                't.nome as turma',
                'up.name as professor',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->orderBy('c.pontosGerados', 'desc')
            ->get();

        return view('relatorio.relatorioCertificados', compact('certificados'));
    }
    public function relatorioPorProfessor(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('professores as p', 'c.idProfessor', '=', 'p.idProfessor')
            ->leftJoin('users as up', 'up.id', '=', 'p.user_id')
            ->whereNotNull('c.idProfessor')
            ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]) // <-- Adicione este filtro
            ->select(
                'p.idProfessor',
                'up.name as professor',
                'u.name',
                't.nome',
                'c.statusCertificado',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->orderBy('up.name')
            ->get();

        // Agrupa os certificados por professor
        $relatorios = $certificados->groupBy('professor')->map(function ($certs, $professor) {
            return [
                'professor' => $professor,
                'certificados' => $certs,
            ];
        })->values();

        return view('relatorio.relatorioProfessores', compact('relatorios'));
    }


    public function relatorioAprovados(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $certificados = DB::table('certificados as c')
            ->join('alunos as a', 'c.idAluno', '=', 'a.idAluno')
            ->join('turmas as t', 't.id', '=', 'a.idTurma')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('professores as p', 'c.idProfessor', '=', 'p.idProfessor')
            ->leftJoin('users as up', 'up.id', '=', 'p.user_id') // Nome do professor
            ->where('c.statusCertificado', '=', 'aprovado')
            ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]) // <-- Filtro de período
            ->select(
                'c.idCertificado',
                'u.name as aluno',
                't.nome as turma',
                'up.name as professor',
                'c.justificativa',
                'c.semestre',
                'c.cargaHoraria',
                'c.dataEnvio',
                'c.pontosGerados'
            )
            ->orderBy('c.dataEnvio', 'desc')
            ->get();
        return view('relatorio.relatorioCertificados', compact('certificados'));
    }
    public function relatorioPorTurma(Request $request)
    {
        $dataInicio = $request->input('data_inicio'); // Ex: '2025-01-01'
        $dataFim = $request->input('data_fim');       // Ex: '2025-12-31'

        $dadosTurmasRaw = DB::table('turmas as t')
            ->leftJoin('alunos as a', 'a.idTurma', '=', 't.id')
            ->leftJoin('users as u', 'u.id', '=', 'a.user_id')
            ->leftJoin('certificados as c', function ($join) use ($dataInicio, $dataFim) {
                $join->on('c.idAluno', '=', 'a.idAluno')
                    ->where('c.statusCertificado', '=', 'aprovado')
                    ->whereBetween('c.dataEnvio', [$dataInicio, $dataFim]);
            })
            ->select(
                't.nome as nome',
                'u.name as nomeAluno',
                DB::raw('SUM(c.cargaHoraria) as cargaHoraria'),
                'a.pontosRecebidos as pontosGerados',
                'a.statusDeConclusao as situacao'
            )
            ->groupBy('t.nome', 'u.name', 'a.pontosRecebidos', 'a.statusDeConclusao')
            ->orderBy('t.nome')
            ->orderBy('u.name')
            ->get();

        // Agrupa alunos por turma
        $dadosTurmas = [];

        foreach ($dadosTurmasRaw as $linha) {
            $turmaNome = $linha->nome;

            if (!isset($dadosTurmas[$turmaNome])) {
                $dadosTurmas[$turmaNome] = [
                    'nome' => $turmaNome,
                    'alunos' => []
                ];
            }

            // Se não houver aluno (null), adiciona um aluno vazio para não quebrar o loop
            if ($linha->nomeAluno !== null) {
                $dadosTurmas[$turmaNome]['alunos'][] = [
                    'nomeAluno' => $linha->nomeAluno,
                    'cargaHoraria' => $linha->cargaHoraria ?? 0,
                    'pontosGerados' => $linha->pontosGerados ?? 0,
                    'situacao' => $linha->situacao ?? 'Não informado',
                ];
            }
        }

        $dadosTurmas = array_values($dadosTurmas);

        return view('relatorio.relatorioTurma', compact('dadosTurmas'));
    }


    public function atualizar(Request $request, $id)
    {
        $certificado = Certificado::findOrFail($id);
        $certificado->updated_at = now();
        $certificado->update($request->only([
            'cargaHoraria',
            'semestre',
            'statusCertificado',
            'justificativa',
            'idProfessor',
            'idAtividadeComplementar',
            'idTipoAtividade'
        ]));

        $this->aprovar($certificado->idCertificado); // Chama a função de aprovação para recalcular os pontos

        return redirect()->back()->with('success', 'Certificado atualizado com sucesso!');
    }
}

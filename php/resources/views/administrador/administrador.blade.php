@extends('administrador.baseadministrador')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
@endpush

@section('right-panel')
    <div class="cards-coluna-direita">
        <div class="card-busca">
            <h1>BUSCAR ALUNO</h1>
            <form class="busca-form" method="GET" action="{{ route('administrador.buscarAluno') }}">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ request('nome') }}">
                <label for="turma">Turma:</label>
                <input type="text" id="turma" name="turma" value="{{ request('turma') }}">
                <button class="btn-buscar" type="submit">BUSCAR</button>
            </form>
            <table class="busca-tabela">
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>NOME</th>
                        <th>TURMA</th>
                        <th>RELATÓRIO PESSOAL</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($alunos) && count($alunos))
                        @foreach ($alunos as $index => $aluno)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aluno->name }}</td>
                                <td>{{ $aluno->nomeTurma }}</td>
                                <td>
                                    <a
                                        href="{{ route('administrador.gerarRelatorio', ['numIdentidade' => $aluno->numIdentidade]) }}">VER
                                        RELATÓRIO</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">Nenhum aluno encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card-relatorio">
            <h2>GERAR RELATÓRIO</h2>
            <div class="periodo-titulo">Período</div>
            <form class="relatorio-form">
                <div class="relatorio-datas">
                    <div>
                        <label for="data_inicio">Data Início</label>
                        <input type="date" id="data_inicio" name="data_inicio">
                    </div>
                    <div>
                        <label for="data_fim">Data Fim</label>
                        <input type="date" id="data_fim" name="data_fim">
                    </div>
                </div>
                <div class="relatorio-opcoes">
                    <div>
                        <span>Ordem:</span>
                        <label><input type="checkbox" name="ordem" value="turma"> Por turma</label>
                        <label><input type="checkbox" name="ordem" value="professor"> Professor</label>
                        <label><input type="checkbox" name="ordem" value="aprovados"> Aprovados</label>
                    </div>
                    <div>
                        <label><input type="checkbox" name="pontos" value="pontos"> Pontos recebidos</label>
                        <label><input type="checkbox" name="horas" value="horas"> Por horas</label>
                        <label><input type="checkbox" name="recusados" value="recusados"> Recusados</label>
                    </div>
                </div>
                <button type="submit" class="btn-relatorio">GERAR RELATÓRIO</button>
            </form>
        </div>

        <div class="card-tabela">
            <div class="tabela-header">
                <span>ALUNOS APROVADOS</span>
                <button class="btn-voltar" title="Voltar">&#60;</button>
            </div>
            <table class="tabela-aprovados">
                <thead>
                    <tr>
                        <th>ALUNO</th>
                        <th>TURMA</th>
                        <th>CONCLUSÃO</th>
                        <th>SUAP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aprovados as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->turma }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->dataConclusao)->format('d/m/Y') }}</td>
                            <td>
                                
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

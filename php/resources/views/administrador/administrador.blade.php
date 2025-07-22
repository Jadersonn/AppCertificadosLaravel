@extends('administrador.baseadministrador')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
@endpush

@section('right-panel')
    <div class="cards-coluna-direita">
        <div class="card-busca">
            <h6>BUSCAR ALUNO</h6>
            <form class="busca-form" method="GET" action="{{ route('aluno.buscar') }}" target="_blank">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ request('nome') }}">

                <label for="turma">Turma:</label>
                <input type="text" id="turma" name="turma" value="{{ request('turma') }}">

                <button class="btn-buscar" type="submit">BUSCAR</button>
            </form>
            <div class="busca-tabela-scroll">
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
                                        <a href="{{ url('/relatorio/aluno/' . $aluno->numIdentidade) }}" target="_blank">VER
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
        </div>

        <div class="card-relatorio">
            <h6>GERAR RELATÓRIO</h6>
            <div class="periodo-titulo">Período:</div>
            <form class="relatorio-form" method="POST" action="{{ route('certificado.relatorio') }}" target="_blank">
                @csrf
                <div class="relatorio-datas">
                    <div>
                        <label for="data_inicio">Data Início</label>
                        <input type="date" id="data_inicio" name="data_inicio" required>
                    </div>
                    <div>
                        <label for="data_fim">Data Fim</label>
                        <input type="date" id="data_fim" name="data_fim" required>
                    </div>
                </div>
                <div class="relatorio-opcoes-row">
                    <div class="relatorio-opcoes1">
                        <div>
                            <div class="ordem-titulo">Ordem:</div>
                            <label>
                                <input type="radio" name="ordem" value="turma" id="categoria" checked> Por turma
                            </label>
                            <label>
                                <input type="radio" name="ordem" value="professor"> Professor
                            </label>
                            <label>
                                <input type="radio" name="ordem" value="aprovados"> Aprovados
                            </label>
                        </div>
                    </div>
                    <div class="relatorio-opcoes2">
                        <div>
                            <br>
                            <label><input type="radio" name="ordem" value="pontos"> Pontos recebidos</label>
                            <label><input type="radio" name="ordem" value="horas"> Por horas</label>
                            <label><input type="radio" name="ordem" value="recusados"> Recusados</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-relatorio">GERAR RELATÓRIO</button>
            </form>
        </div>

        <div class="card-tabela">
            <div class="tabela-header">
                <span><h6 id="titulo-tabela">ALUNOS APROVADOS</h6></span>
                <button class="btn-voltar" title="Voltar">&#60;</button>
                 <button class="btn-voltar-aprovados" title="Voltar" style="display:none;">&#60;</button>
            </div>
            <div id="tabelaAprovadosContainer">
                <div class="tabela-aprovados-scroll busca-tabela-scroll">
                    <table class="tabela-aprovados tabela-pequena busca-tabela busca-tabela-scroll">
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
                                    <td><a href="{{ route('certificado.relatorioSuap', ['id' => $item->idAluno]) }}" target="_blank">Visualizar</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tabelaRelatorioTurmasContainer" style="display:none;">
                    
                <div class="tabela-aprovados-scroll">
                    <table class="tabela-aprovados tabela-pequena busca-tabela busca-tabela-scroll">
                        <thead>
                            <tr>
                                <th>TURMAS</th>
                                <th>RELATÓRIO</th>
                                <th>CONCLUSÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ir para relatório de turmas
    document.querySelector('.btn-voltar').addEventListener('click', function() {
        document.getElementById('tabelaAprovadosContainer').style.display = 'none';
        document.getElementById('tabelaRelatorioTurmasContainer').style.display = 'block';
        document.getElementById('titulo-tabela').textContent = 'RELATÓRIO DE TURMAS';
        this.style.display = 'none';
        document.querySelector('.btn-voltar-aprovados').style.display = 'inline-block';
    });

    // Voltar para alunos aprovados
    document.querySelector('.btn-voltar-aprovados').addEventListener('click', function() {
        document.getElementById('tabelaRelatorioTurmasContainer').style.display = 'none';
        document.getElementById('tabelaAprovadosContainer').style.display = 'block';
        document.getElementById('titulo-tabela').textContent = 'ALUNOS APROVADOS';
        this.style.display = 'none';
        document.querySelector('.btn-voltar').style.display = 'inline-block';
    });

    // Inicialmente, o botão de voltar da tabela de turmas fica oculto
    document.querySelector('.btn-voltar-aprovados').style.display = 'none';
});
</script>

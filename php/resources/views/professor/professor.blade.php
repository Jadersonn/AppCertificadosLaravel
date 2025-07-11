@extends('professor.baseprofessor')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/layouts/professor.css') }}">
@endpush

@section('main')
<div class="certificados-recebidos-box">
    <h1>CERTIFICADOS RECEBIDOS</h1>
    <div class="certificados-tabela-container">
        <table class="certificados-tabela">
            <thead>
                <tr>
                    <th>ALUNO</th>
                    <th>TURMA</th>
                    <th>CATEGORIA</th>
                    <th>INICIO</th>
                    <th>CONCLUSÃO</th>
                    <th>SEMESTRE</th>
                    <th>HORAS</th>
                    <th>ARQUIVO</th>
                    <th>APROVAÇÃO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
    <div class="professor-cards-row">
        <!-- GERAR RELATÓRIO -->
        <div class="professor-card">
            <div class="professor-card-title">GERAR RELATÓRIO</div>
            <div class="professor-card-subtitle">Período</div>
            <div class="professor-card-row">
                <div>
                    <label>Data Início</label>
                    <input type="date" name="data_inicio">
                </div>
                <div>
                    <label>Data Fim</label>
                    <input type="date" name="data_fim">
                </div>
            </div>
            <div class="professor-card-row ordem">
                <div>
                    <span>Ordem:</span>
                    <div><input type="radio" id="porTurma" name="ordem" value="porTurma"><label for="porTurma"> Por
                            turma</label></div>
                    <div><input type="radio" id="professor" name="ordem" value="professor"><label for="professor">
                            Professor</label></div>
                    <div><input type="radio" id="aprovados" name="ordem" value="aprovados"><label for="aprovados">
                            Aprovados</label></div>
                </div>
                <div>
                    <div><input type="radio" id="pontosRecebidos" name="ordem" value="pontosRecebidos"><label
                            for="pontosRecebidos"> Pontos recebidos</label></div>
                    <div><input type="radio" id="porHoras" name="ordem" value="porHoras"><label for="porHoras"> Por
                            horas</label></div>
                    <div><input type="radio" id="recusados" name="ordem" value="recusados"><label for="recusados">
                            Recusados</label></div>
                </div>
            </div>
            <button class="professor-card-btn">GERAR RELATÓRIO</button>
        </div>

        <!-- BUSCAR ALUNO -->
        <div class="professor-card">
            <div class="professor-card-title">BUSCAR ALUNO</div>
            <div class="professor-card-row">
                <div>
                    <label>Nome:</label>
                    <input type="text" name="nome">
                </div>
                <div>
                    <label>Turma:</label>
                    <input type="text" name="turma">
                </div>
            </div>
            <table class="professor-card-table">
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>NOME</th>
                        <th>RELATÓRIO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Aluno 1</td>
                        <td><a href="#">Ver</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Aluno 2</td>
                        <td><a href="#">Ver</a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Aluno 3</td>
                        <td><a href="#">Ver</a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Aluno 4</td>
                        <td><a href="#">Ver</a></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Aluno 5</td>
                        <td><a href="#">Ver</a></td>
                    </tr>
                </tbody>
            </table>
            <button class="professor-card-btn">BUSCAR</button>
        </div>

        <!-- ALUNOS APROVADOS -->
        <div class="professor-card">
            <div class="professor-card-title">ALUNOS APROVADOS</div>
            <table class="professor-card-table">
                <thead>
                    <tr>
                        <th>ALUNO</th>
                        <th>TURMA</th>
                        <th>CONCLUSÃO</th>
                        <th>SUAP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Aluno 1</td>
                        <td>3A</td>
                        <td>01/06/2024</td>
                        <td>Sim</td>
                    </tr>
                    <tr>
                        <td>Aluno 2</td>
                        <td>2B</td>
                        <td>15/05/2024</td>
                        <td>Sim</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- filepath: c:\Users\jader\OneDrive\Documents\tcc\AppCertificadosLaravel\php\resources\views\relatorio\suapAluno.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório SUAP do Aluno</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/suap.css') }}">
</head>

<body>
    <div class="container">
        <h1>REGULAMENTO DA ORGANIZAÇÃO-DIDÁTICO PEDAGÓGICA DO INSTITUTO FEDERAL DE
            EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DE MATO GROSSO DO SUL </h1>
        <h1>Anexo II</h1>
        <h1>FICHA DE REGISTRO DAS ATIVIDADES COMPLEMENTARES</h1>
        <div class="info"><strong>ESTUDANTE:</strong> {{ $aluno->user->name }}</div>
        <div class="info"><strong>CURSO:</strong> {{ $conclusao->curso ?? '-' }}</div>
        <div class="info"><strong>TURNO:</strong> {{ $conclusao->turno ?? '-' }}</div>
        <div class="info"><strong>ANO/PERÍODO DE INGRESSO:</strong> {{ $conclusao->ano_ingresso ?? '-' }}</div>
        <div class="info"><strong>ANO/PERÍODO DE CONCLUSÃO: </strong> {{ $conclusao->ano_conclusao ?? '-' }}</div>

        <table>
            <thead>
                <tr>
                    <th>ATIVIDADE</th>
                    <th>CATEGORIA</th>
                    <th>DATA / HORA</th>
                    <th>PERÍODO</th>
                    <th>PONTUAÇÃO CONFERIDA</th>
                </tr>
            </thead>
            <tbody>
                @php $cargaHorariaTotal = 0; @endphp
                @forelse($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->atividadeComplementar->nomeAtividadeComplementar ?? '-' }}</td>
                        <td>{{ $certificado->atividadeComplementar->indice }}</td>
                        <td>{{ \Carbon\Carbon::parse($certificado->dataEnvio)->format('d/m/Y') }}</td>
                        <td>{{ $certificado->semestre ?? '-' }}</td>
                        <td>{{ $certificado->pontosGerados }}</td>
                    </tr>
                    @php $cargaHorariaTotal += $certificado->cargaHoraria; @endphp
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhuma atividade registrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        <div class="info"><strong>CARGA HORÁRIA TOTAL: {{ $cargaHorariaTotal }}h</strong></div>
        <div class="info"><strong>SITUAÇÃO DO ESTUDANTE:
            @if ($aluno->statusDeConclusao === 'aprovado')
                APROVADO
            @elseif ($aluno->statusDeConclusao === 'reprovado')
                REPROVADO
            @elseif ($aluno->statusDeConclusao === 'em andamento')
                PENDENTE
            @else
                -
            @endif
        </strong> </div>
        <div class="info"><strong>Data de recebimento (CEREL):</strong> _____/_____/_____</div>
        <div class="info"><strong>Servidor CEREL:</strong> ____________________</div>
        <div class="footer">
            Instituto Federal de Mato Grosso do Sul - Campus Corumbá<br>
            Relatório gerado automaticamente pelo sistema. Em: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
    </div>
</body>

</html>

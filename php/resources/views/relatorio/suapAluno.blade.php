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
        <img src="{{ asset('imagens/cabecalho.png') }}" class="logo" alt="Cabeçalho do Relatório">
        <h1>REGULAMENTO DA ORGANIZAÇÃO-DIDÁTICO PEDAGÓGICA DO INSTITUTO FEDERAL DE
            EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DE MATO GROSSO DO SUL </h1>
        <h1>Anexo II</h1>
        <h1>FICHA DE REGISTRO DAS ATIVIDADES COMPLEMENTARES</h1>
        <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
        <div class="info"><strong>ESTUDANTE:</strong> {{ $aluno->user->name }}</div>
        <div class="info"><strong>CURSO:</strong> {{ $aluno->user->numIdentidade ?? '-' }}</div>
        <div class="info"><strong>TURNO:</strong> {{ $aluno->turma->nome ?? '-' }}</div>
        <div class="info"><strong>ANO/PERÍODO DE INGRESSO:</strong></div>
        <div class="info"><strong>ANO/PERÍODO DE CONCLUSÃO: </strong></div>

        <div class="section-title" style="margin-top:30px;">Atividades Complementares Registradas</div>
        <table>
            <thead>
                <tr>
                    <th>ATIVIDADE</th>
                    <th>CATEGORIA</th>
                    <th>DATA / HORA</th>
                    <th>PERÍODO</th>
                    <th>CARGA CONFERIDA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificados as $certificado)
                    
                @endforelse
            </tbody>
        </table>
        <div class="info"><strong>CARGA HORÁRIA TOTAL:</strong> {{ $cargaHorariaTotal }}h</div>
        <div class="info"><strong>SITUAÇÃO DO ESTUDANTE:</strong> {{ $situacaoEstudante }}</div>
        <div class="info"><strong>Data de recebimento (CEREL):</strong> / / </div>
        <div class="info"><strong>Servidor CEREL:</strong> {{ $servidorCerel }}</div>
        <div class="footer">
            Instituto Federal de Mato Grosso do Sul - Campus Corumbá<br>
            Relatório gerado automaticamente pelo sistema. Em: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
    </div>
</body>

</html>

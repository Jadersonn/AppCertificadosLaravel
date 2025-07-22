<!-- filepath: resources/views/relatorio/relatorioCertificados.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Certificados Rejeitados</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/relatorio.css') }}">
</head>

<body>
    <div class="container">
        <img src="{{ asset('imagens/cabecalho.png') }}" class="logo" alt="Cabeçalho do Relatório">
        <h1>Relatório de Certificados Rejeitados</h1>
        <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <table>
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Turma</th>
                    <th>Professor</th>
                    <th>Justificativa</th>
                    <th>Semestre</th>
                    <th>Carga Horária</th>
                    <th>Data de Envio</th>
                    <th>Pontos</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->aluno ?? '-' }}</td>
                        <td>{{ $certificado->turma ?? '-' }}</td>
                        <td>{{ $certificado->professor ?? '-' }}</td>
                        <td>{{ $certificado->justificativa ?? '-' }}</td>
                        <td>{{ $certificado->semestre ?? '-' }}</td>
                        <td>{{ $certificado->cargaHoraria }}h</td>
                        <td>{{ \Carbon\Carbon::parse($certificado->dataEnvio)->format('d/m/Y') }}</td>
                        <td>{{ $certificado->pontosGerados }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;">Nenhum certificado rejeitado encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Instituto Federal de Mato Grosso do Sul - Campus Corumbá<br>
            Relatório gerado automaticamente pelo sistema. Em: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
    </div>
</body>

</html>

<!-- resources/views/relatorio/relatorioProfessor.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Certificados do Professor</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/relatorio.css') }}">
</head>

<body>
    <div class="container">
        <img src="{{ asset('imagens/cabecalho.png') }}" class="logo" alt="Cabeçalho do Relatório">
        <h1>Relatório de Certificados Avaliados</h1>

        <div class="info"><strong>Professor:</strong> {{ $professor->name }}</div>
        <div class="info"><strong>Identidade:</strong> {{ $professor->numIdentidade }}</div>
        <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <div class="section-title">Certificados Avaliados</div>
        <table>
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Turma</th>
                    <th>Status</th>
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
                        <td>{{ $certificado->name }}</td>
                        <td>{{ $certificado->nome }}</td>
                        <td>
                            @if ($certificado->statusCertificado === 'aprovado')
                                <span style="color:green;font-weight:bold;">Aprovado</span>
                            @elseif ($certificado->statusCertificado === 'rejeitado')
                                <span style="color:red;font-weight:bold;">Rejeitado</span>
                            @else
                                <span style="color:orange;">Pendente</span>
                            @endif
                        </td>
                        <td>{{$certificado->justificativa ?? '-'}}</td>
                        <td>{{ $certificado->semestre }}</td>
                        <td>{{ $certificado->cargaHoraria }}h</td>
                        <td>{{ \Carbon\Carbon::parse($certificado->dataEnvio)->format('d/m/Y') }}</td>
                        <td>{{ $certificado->pontosGerados }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Nenhum certificado avaliado.</td>
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

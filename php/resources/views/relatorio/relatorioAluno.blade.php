<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Certificados</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/relatorio.css') }}">
</head>

<body>
    <div class="container">

        <img src="{{ asset('imagens/cabecalho.png') }}" class="logo" alt="cabecalho do relatorio">
        <h1>Relatório de Certificados</h1>

        <div class="info"><strong>Aluno:</strong> {{ $aluno->user->name }}</div>
        <div class="info">
            <strong>Status:</strong>
            @if ($aluno->statusDeConclusao === 'aprovado')
                <span style="color:green;font-weight:bold;">Aprovado</span>
            @elseif ($aluno->statusDeConclusao === 'em andamento')
                <span style="color:orange;font-weight:bold;">Pendente</span>
            @else
                <span style="color:gray;">Indefinido</span>
            @endif
        </div>
        <div class="info"><strong>Turma:</strong> {{ $aluno->turma->nome ?? '-' }}</div>
        <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <div class="section-title">Certificados Registrados</div>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Professor</th>
                    <th>Carga Horária</th>
                    <th>Pontos</th>
                    <th>Data de Envio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->categoria }}</td>
                        <td>
                            @if ($certificado->nomeProfessor)
                                {{ $certificado->nomeProfessor }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $certificado->cargaHoraria }}h</td>
                        <td>{{ $certificado->pontosGerados }}</td>
                        <td>{{ \Carbon\Carbon::parse($certificado->dataEnvio)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhum certificado registrado.</td>
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

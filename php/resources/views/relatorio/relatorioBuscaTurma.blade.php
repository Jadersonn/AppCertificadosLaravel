<!-- filepath: c:\Users\jader\OneDrive\Documents\tcc\AppCertificadosLaravel\php\resources\views\relatorio\relatorioBuscaTurma.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Certificados da Turma</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/relatorio.css') }}">
</head>

<body>
    <div class="container">
        <img src="{{ asset('imagens/cabecalho.png') }}" class="logo" alt="cabecalho do relatorio">
        <h1>Relatório de Certificados das Turmas</h1>
        <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

        <div class="info" style="margin-top:50px;"><strong>Turma:</strong> {{ $turma->nome }}</div>
        <div class="section-title" style="margin-top:1px;">Certificados dos Alunos</div>
        <table>
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Email</th>
                    <th>Matrícula</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->name ?? '-' }}</td>
                        <td>{{ $aluno->email ?? '-' }}</td>
                        <td>{{ $aluno->numIdentidade ?? '-' }}</td>
                        @if($aluno->statusDeConclusao === 'aprovado')
                            <td>Aprovado - <a href="{{ route('certificado.relatorioSuap', ['id' => $aluno->idAluno]) }}" >SUAP</a></td>
                        @else
                            <td>Pendente</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">Nenhum aluno nesta turma.</td>
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
@if ($errors->has('conclusao'))
    <script>
        alert("{{ $errors->first('conclusao') }}");
    </script>
@endif
</html>

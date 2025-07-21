<!-- filepath: c:\Users\Administrador\Downloads\AppCertificadosLaravel\php\resources\views\relatorio\relatorioTurma.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Certificados da Turma</title>
  <link rel="stylesheet" href="{{ asset('css/layouts/relatorio.css') }}">
</head>
<body>
  <div class="container">
    <img src="logoIF.png" class="logo" alt="LogoIFMS">
    <h1>Relatório de Certificados das Turmas</h1>
    <div class="info"><strong>Data de Geração:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>

    @foreach ($dadosTurmas as $turma)
      <div class="info" style="margin-top:30px;"><strong>Turma:</strong> {{ $turma['nome'] }}</div>
      <div class="section-title">Certificados dos Alunos</div>
      <table>
        <thead>
          <tr>
            <th>Aluno</th>
            <th>Carga Horária</th>
            <th>Pontos</th>
            <th>Situação</th>
          </tr>
        </thead>
        <tbody>
          @forelse($turma['alunos'] as $aluno)
          <tr>
            <td>{{ $aluno['nomeAluno'] }}</td>
            <td>{{ $aluno['cargaHoraria'] }}h</td>
            <td>{{ $aluno['pontosGerados'] }}</td>
            <td>{{ $aluno['situacao'] }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="text-align:center;">Nenhum aluno nesta turma.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    @endforeach

    <div class="footer">
      Instituto Federal de Mato Grosso do Sul - Campus Corumbá<br>
      Relatório gerado automaticamente pelo sistema. Em: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
  </div>
</body>
</html>
{{-- resources/views/professor/alunosAprovados.blade.php --}}
<div class="professor-card">
    <div class="professor-card-title">ALUNOS APROVADOS</div>
    <div class="professor-card-table-scroll">
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
                @foreach ($aprovados as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->turma }}</td>
                        <td>{{ $item->dataConclusao }}</td>
                        <td><a href="{{ route('certificado.relatorioSuap', ['id' => $item->idAluno]) }}" target="_blank">Visualizar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if ($errors->has('conclusao'))
    <script>
        alert("{{ $errors->first('conclusao') }}");
    </script>
@endif
{{-- resources/views/professor/buscaAluno.blade.php --}}
<form method="GET" action="{{ route('aluno.buscar') }}" target="_blank">
    <div class="professor-card">
        <div class="professor-card-title">BUSCAR ALUNO</div>
        <div class="professor-card-row">
            <div>
                <label>Nome:</label>
                <input type="text" id="nome" name="nome" value="{{ request('nome') }}">
            </div>
            <div>
                <label>Turma:</label>
                <input type="text" id="turma" name="turma" value="{{ request('turma') }}">
            </div>
        </div>
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
                <tbody id="tbodyBuscaAluno">
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
        <button class="professor-card-btn" type="submit">GERAR RELATÓRIO</button>
    </div>

</form>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nomeInput = document.getElementById('nome');
        const turmaInput = document.getElementById('turma');
        const tbody = document.getElementById('tbodyBuscaAluno');

        function filtrarTabela() {
            const nome = nomeInput.value.toLowerCase();
            const turma = turmaInput.value.toLowerCase();

            Array.from(tbody.querySelectorAll('tr')).forEach(function(row) {
                const tdNome = row.children[1]?.textContent.toLowerCase() || '';
                const tdTurma = row.children[2]?.textContent.toLowerCase() || '';

                if ((nome === '' || tdNome.includes(nome)) &&
                    (turma === '' || tdTurma.includes(turma))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        nomeInput.addEventListener('input', filtrarTabela);
        turmaInput.addEventListener('input', filtrarTabela);
    });
</script>
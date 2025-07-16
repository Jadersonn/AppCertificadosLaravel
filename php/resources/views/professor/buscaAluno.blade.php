{{-- resources/views/professor/buscaAluno.blade.php --}}
<form method="GET" action="{{ route('professor.buscarAluno') }}">
    <div class="professor-card">
        <div class="professor-card-title">BUSCAR ALUNO</div>
        <div class="professor-card-row">
            <div>
                <label>Nome:</label>
                <input type="text" name="nome" value="{{ request('nome') }}">
            </div>
            <div>
                <label>Turma:</label>
                <input type="text" name="turma" value="{{ request('turma') }}">
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
                @if (empty($busca))
                    <tr>
                        <td colspan="3">Insira o nome de um aluno ou turma para realizar uma busca.</td>
                    </tr>
                @else
                    @foreach ($busca as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('professor.relatorioAluno', ['id' => $item->id_user]) }}"
                                    class="professor-card-btn">VER RELATÓRIO</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button class="professor-card-btn" type="submit">BUSCAR</button>
    </div>
</form>

{{-- resources/views/professor/buscaAluno.blade.php --}}
<form method="GET" action="{{ route('aluno.buscar') }}" target="_blank">
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
        <button class="professor-card-btn" type="submit">BUSCAR</button>
    </div>
</form>

{{-- resources/views/professor/geraRelatorio.blade.php --}}
<form method="POST" action="{{ route('certificado.relatorio') }}" target="_blank">
    @csrf
    <div class="professor-card">
        <div class="professor-card-title">GERAR RELATÓRIO</div>
        <div class="professor-card-subtitle">Período</div>
        <div class="professor-card-row">
            <div>
                <label>Data Início</label>
                <input type="date" name="data_inicio" required>
            </div>
            <div>
                <label>Data Fim</label>
                <input type="date" name="data_fim" required>
            </div>
        </div>
        <div class="professor-card-row ordem">
            <div>
                <span>Ordem:</span>
                <div><input type="radio" id="porTurma" name="ordem" value="turma" checked><label for="porTurma"> Por turma</label></div>
                <div><input type="radio" id="professor" name="ordem" value="professor"><label for="professor"> Professor</label></div>
                <div><input type="radio" id="aprovados" name="ordem" value="aprovados"><label for="aprovados"> Aprovados</label></div>
            </div>
            <div>
                <br>
                <div><input type="radio" id="pontosRecebidos" name="ordem" value="pontos"><label for="pontosRecebidos"> Pontos recebidos</label></div>
                <div><input type="radio" id="porHoras" name="ordem" value="horas"><label for="porHoras"> Por horas</label></div>
                <div><input type="radio" id="recusados" name="ordem" value="recusados"><label for="recusados"> Recusados</label></div>
            </div>
        </div>
        <button type="submit" class="professor-card-btn">GERAR RELATÓRIO</button>
    </div>
</form>

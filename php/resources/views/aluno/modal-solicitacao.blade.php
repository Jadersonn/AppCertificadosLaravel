<div id="modal-solicitacao" class="modal-solicitacao" style="display: none;">
    <div class="modal-conteudo">
        <button class="modal-fechar" id="fechar-modal">&times;</button>
        <h2 style="margin-bottom: 1.2em;">Nova Solicitação de Horas</h2>
        <form enctype="multipart/form-data" method="POST" action="{{ route('aluno.certificados') }}">
            @csrf
            <div class="modal-row">
                <div class="modal-col">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Categoria</option>
                        <option value="1">Extensão</option>
                        <option value="2">Pesquisa</option>
                        <option value="3">Ensino</option>
                    </select>
                </div>
                <div class="modal-col">
                    <label for="subcategoria">Sub categoria</label>
                    <select id="subcategoria" name="subcategoria" required aria-placeholder="Sub Categoria">
                        <option value="1">Monitoria</option>
                        <option value="2">Palestra</option>
                        <option value="3">Curso</option>
                    </select>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-col">
                    <label for="semestre">Semestre</label>
                    <select id="semestre" name="semestre" required aria-placeholder="Semestre">
                        <option value="2024-1">2024/1</option>
                        <option value="2024-2">2024/2</option>
                        <option value="2025-1">2025/1</option>
                    </select>
                </div>
                <div class="modal-col">
                    <label for="horas">Horas</label>
                    <input type="number" id="horas" name="horas" placeholder="Horas" required>
                </div>
            </div>
            <div style="margin-bottom: 1em;">
                <label for="arquivo">Arquivo:</label>
                <div class="input-arquivo-wrapper">
                    <input type="file" id="arquivo"  name="arquivo" accept="application/pdf" required>
                    <label for="arquivo" id="arquivo-label">
                        <span id="arquivo-status"><span class="arquivo-mais">+</span><br><span class="arquivo-texto">Selecione um PDF</span></span><span class="arquivo-texto">Até 30MB</span>
                    </label>
                </div>
            </div>
            <div style="text-align: right;">
                <button type="submit" class="modal-enviar">Enviar</button>
            </div>
        </form>
    </div>
</div>

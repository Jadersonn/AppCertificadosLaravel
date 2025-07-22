<!-- filepath: c:\Users\jader\OneDrive\Documents\tcc\AppCertificadosLaravel\php\resources\views\aluno\modal-conclusao.blade.php -->
<div id="modal-conclusao" class="modal-solicitacao" style="display: none;">
    <div class="modal-conteudo" id="modal-conclusao-content">
        <button class="modal-fechar" id="fechar-modal-conclusao">&times;</button>
        <h2 style="margin-bottom: 1.2em;">Informações de Conclusão</h2>
        <form method="POST" action="{{ route('aluno.salvarConclusao') }}">
            @csrf
            <div class="modal-row">
                <div class="modal-col">
                    <label for="curso">Nome do Curso por Extenso<span style="color:red">*</span></label>
                    <input type="text" id="curso" name="curso" required class="input-arredondado" placeholder="Digite o curso" required>
                </div>
                <div class="modal-col">
                    <label for="turno">Turno <span style="color:red">*</span></label>
                    <select id="turno" name="turno" required class="input-arredondado" required>
                        <option value="" disabled selected>Selecione o turno</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Noturno">Noturno</option>
                        <option value="Integral">Integral</option>
                    </select>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-col">
                    <label for="ano_ingresso">Ano/Período de Ingresso <span style="color:red">*</span></label>
                    <input type="text" id="ano_ingresso" name="ano_ingresso" required class="input-arredondado" placeholder="Ex: 2022/1" required>
                </div>
                <div class="modal-col">
                    <label for="ano_conclusao">Ano/Período de Conclusão <span style="color:red">*</span></label>
                    <input type="text" id="ano_conclusao" name="ano_conclusao" required class="input-arredondado" placeholder="Ex: 2025/2" required>
                </div>
            </div>
            <div style="text-align: right;">
                <button type="submit" class="modal-enviar" required>Salvar</button>
            </div>
        </form>
    </div>
</div>
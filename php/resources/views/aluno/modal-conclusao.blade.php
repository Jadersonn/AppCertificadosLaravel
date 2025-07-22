<!-- filepath: c:\Users\jader\OneDrive\Documents\tcc\AppCertificadosLaravel\php\resources\views\aluno\modal-conclusao.blade.php -->
<div id="modal-conclusao" class="modal-solicitacao" style="display: none;">
    <div class="modal-conteudo" id="modal-conclusao-content">
        <button class="modal-fechar" id="fechar-modal">&times;</button>
        <h2 style="margin-bottom: 1.2em;">Informações de Conclusão</h2>
        <form method="POST" action="">
            @csrf
            <div class="modal-row">
                <div class="modal-col">
                    <label for="curso">Curso</label>
                    <input type="text" id="curso" name="curso" required class="input-arredondado" placeholder="Digite o curso">
                </div>
                <div class="modal-col">
                    <label for="turno">Turno</label>
                    <select id="turno" name="turno" required class="input-arredondado">
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
                    <label for="ano_ingresso">Ano/Período de Ingresso</label>
                    <input type="text" id="ano_ingresso" name="ano_ingresso" required class="input-arredondado" placeholder="Ex: 2022/1">
                </div>
                <div class="modal-col">
                    <label for="ano_conclusao">Ano/Período de Conclusão</label>
                    <input type="text" id="ano_conclusao" name="ano_conclusao" required class="input-arredondado" placeholder="Ex: 2025/2">
                </div>
            </div>
            <div style="text-align: right;">
                <button type="submit" class="modal-enviar">Salvar</button>
            </div>
        </form>
    </div>
</div>
<div id="modal-solicitacao" class="modal-solicitacao" style="display: none;">
  <div class="modal-conteudo">
    <button class="modal-fechar" id="fechar-modal">&times;</button>
    <h2 style="margin-bottom: 1.2em;">Nova Solicitação de Horas</h2>
    <form enctype="multipart/form-data">
      
      <div class="modal-row">
        <div class="modal-col">
          <label for="categoria">Categoria</label>
          <!-- Aqui passei o ID esperado pelo seu JS -->
          <select id="auto-width-select" name="categoria" required>
            <option value="categoria">Categoria</option>
            <option value="extensao">Extensão</option>
            <option value="pesquisa">Pesquisa</option>
            <option value="ensino">Ensino</option>
          </select>
        </div>
        <div class="modal-col">
          <label for="subcategoria">Sub categoria</label>
          <select id="subcategoria" name="subcategoria" required>
            <option value="">Sub Categoria</option>
            <option value="monitoria">Monitoria</option>
            <option value="palestra">Palestra</option>
            <option value="curso">Curso</option>
          </select>
        </div>
      </div>
      
      <div class="modal-row">
        <div class="modal-col">
          <label for="semestre">Semestre</label>
          <select id="semestre" name="semestre" required>
            <option value="">Semestre</option>
            <option value="2024-1">2024/1</option>
            <option value="2024-2">2024/2</option>
            <option value="2025-1">2025/1</option>
          </select>
        </div>
        <div class="modal-col">
          <label for="horas">Horas</label>
          <input type="text" id="horas" name="horas" placeholder="Horas" required>
        </div>
      </div>
      
      <div style="margin-bottom: 1em;">
        <label for="arquivo">Arquivo:</label>
        <div class="input-arquivo-wrapper">
          <input type="file" id="arquivo" name="arquivo" accept="application/pdf" required>
          <label for="arquivo" id="arquivo-label">
            <span id="arquivo-status">
              <span class="arquivo-mais">+</span><br>
              <span class="arquivo-texto">Selecione um PDF</span>
            </span>
          </label>
        </div>
      </div>
      
      <div style="text-align: right;">
        <!-- Incluí também a classe enviar-btn para o seu script de abertura do modal -->
        <button type="submit" class="enviar-btn">ENVIAR</button>
      </div>
      
    </form>
  </div>
</div>

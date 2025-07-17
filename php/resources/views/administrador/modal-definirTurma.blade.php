<!-- Modal Definir Turma -->
<div class="modal fade" id="turmaModal" tabindex="-1" aria-labelledby="turmaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content modal-turma-content">
      <div class="modal-header border-0">
        <h2 class="modal-turma-titulo w-100 text-center" id="turmaModalLabel">GERENCIADOR DE TURMAS</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body modal-turma-body">
        <div class="row">
          <div class="col-md-7 d-flex flex-column justify-content-start">
            <label for="nomeAluno" class="form-label mt-2">NOME DO ALUNO</label>
            <input type="text" id="nomeAluno" class="form-control mb-2" placeholder="Nome do aluno">
            <label for="cpfAluno" class="form-label">CPF</label>
            <input type="text" id="cpfAluno" class="form-control mb-2" placeholder="CPF do aluno">
            <label for="turmaAluno" class="form-label">TURMA</label>
            <input type="text" id="turmaAluno" class="form-control mb-3" placeholder="Turma do aluno">
            <div class="bg-white rounded p-2 mt-2">
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th style="width: 400px;"></th>
                    <th>NOME</th>
                    <th>CPF</th>
                    <th>TURMA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><span style="color:red; cursor:pointer; text-align: center;">&#10006;</span></td>
                    <td class="fw-bold">JADERSON DA SILVA PILLAR MARTINS</td>
                    <td class="fw-bold">052476...0X</td>
                    <td>SEM TURMA</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-5 d-flex flex-column gap-3">
            <div class="bg-white rounded p-2">
              <span class="fw-bold d-block mb-1 modal-turma-label">TURMAS EXISTENTES</span>
              <table class="table table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>NOME</th>
                    <th>ALUNOS</th>
                    <th>EDITAR</th>
                    <th>DELETAR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>32215</td>
                    <td>8</td>
                    <td><button class="btn btn-sm btn-warning btn-editar" title="Editar">✏️</button></td>
                    <td><button class="btn btn-sm btn-danger btn-deletar" title="Deletar">❌</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="bg-white rounded p-2">
              <span class="fw-bold d-block mb-1 modal-turma-label">CRIAR TURMA</span>
              <input type="text" class="form-control mb-2">
              <button class="btn btn-primary w-100">CRIAR</button>
            </div>
            <div class="bg-white rounded p-2">
              <span class="fw-bold d-block mb-1 modal-turma-label">ADICIONAR ALUNO(s) PARA TURMA</span>
              <select class="form-select"></select>
            </div>
          </div>
        </div>
        <button class="btn btn-primary w-100 mt-4">SALVAR</button>
      </div>
    </div>
  </div>
</div>

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

                        <div class="bg-white rounded p-2 mt-2 modal-turma-table-scroll alunos">
                            <span class="modal-turma-table-title">ALUNOS:</span>
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>NOME</th>
                                        <th>CPF</th>
                                        <th>TURMA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alunos as $aluno)
                                        <tr>
                                            <td class="fw-bold">{{ $aluno->name }}</td>
                                            <td class="fw-bold">{{ $aluno->numIdentidade }}</td>
                                            <td class="fw-bold">{{ $aluno->nomeTurma }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex flex-column gap-3">
                        <div class="bg-white rounded p-2 modal-turma-table-scroll">
                            <span class="fw-bold d-block mb-1 modal-turma-label">TURMAS EXISTENTES</span>
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>NOME</th>
                                        <th>ALUNOS</th>
                                        <th>LINK</th>
                                        <th>DELETAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turmas as $turma)
                                        <tr>
                                            <td class="fw-bold">{{ $turma->nome }}</td>
                                            <td class="fw-bold">
                                                {{ $turma->totalAlunos }}
                                            </td>
                                            <td>
                                                <a href="{{ url('/register/aluno/' . $turma->id) }}" class="btn btn-sm btn-warning btn-editar"
                                                    title="Registrar sala" target="_blank">
                                                    LINK
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('administrador.deletarTurma', ['id' => $turma->id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-deletar"
                                                        title="Deletar">
                                                        <img src="{{ asset('imagens/professor/reject.ico') }}" alt="Deletar"
                                                            width="20">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="bg-white rounded p-2">
                            <form action="{{ route('administrador.criarTurma') }}" method="POST">
                                @csrf
                                <span class="fw-bold d-block mb-1 modal-turma-label">CRIAR TURMA</span>
                                <input type="text" id="nomeTurma" name="nome" class="form-control mb-2">
                                <button type="submit" class="modal-turma-btn-criar">CRIAR</button>
                            </form>
                        </div>
                        <div class="bg-white rounded p-2">
                            <form action="{{ route('administrador.definirTurma') }}" method="POST">
                                @csrf
                                <label for="selectTurma" class="form-label">ADICIONAR ALUNO(s) PARA TURMA</label>
                                <select id="selectTurma" name="turma_id" class="form-select mb-2" required>
                                    <option value="">Selecione uma turma</option>
                                    @foreach ($turmas as $turma)
                                        <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                                    @endforeach
                                </select>
                                <table class="table table-bordered align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;"></th>
                                            <th>NOME</th>
                                            <th>CPF</th>
                                            <th>TURMA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alunos as $aluno)
                                            <tr>
                                                <td align="center">
                                                    <input type="checkbox" name="alunos[]" value="{{ $aluno->idAluno }}">
                                                </td>
                                                <td class="fw-bold">{{ $aluno->name }}</td>
                                                <td class="fw-bold">{{ $aluno->numIdentidade }}</td>
                                                <td class="fw-bold">{{ $aluno->nomeTurma }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="modal-turma-btn-salvar">SALVAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

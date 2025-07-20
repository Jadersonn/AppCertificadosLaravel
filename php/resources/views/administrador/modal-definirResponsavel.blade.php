<!-- Modal Definir Responsável -->
<div class="modal fade" id="responsavelModal" tabindex="-1" aria-labelledby="responsavelModalLabel" aria-hidden="true">
    <div class="modal-conteudo">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
                    <h5 class="modal-title" id="responsavelModalLabel">Painel de Controle de Professor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <!-- Seu conteúdo aqui -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nomeProfessor" class="form-label">NOME</label>
                            <input type="text" class="form-control" id="nomeProfessor"
                                placeholder="Nome do professor">
                        </div>
                        <div class="col-md-6">
                            <label for="suap" class="form-label">SUAP</label>
                            <input type="text" class="form-control" id="suap" placeholder="SUAP">
                        </div>
                    </div>

                    <!-- Tabela Professores Ativos -->
                    <h6 class="mt-4"><strong>PROFESSORES ATIVOS</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered bg-white text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>NOME</th>
                                    <th>SUAP</th>
                                    <th>APROVA CERTIFICADOS</th>
                                    <th>ADMIN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($professores as $professor)
                                    <tr>
                                        <td>{{ $professor->name }}</td>
                                        <td>{{ $professor->numIdentidade }}</td>
                                        @if ($professor->funcao == 'administrador')
                                            <td>
                                                <!-- Tornar professor -->
                                                <form method="POST" action="{{ route('administrador.edit', ['idnumIdentidade' => $professor->numIdentidade]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="nova_funcao" value="professor">
                                                    <button type="submit" class="btn btn-danger btn-sm">NÃO</button>
                                                </form>
                                            </td>
                                            <td>
                                                <!-- Já é admin, botão SIM desabilitado -->
                                                <button type="button" class="btn btn-success btn-sm" disabled>SIM</button>
                                            </td>
                                        @else
                                            <td>
                                                <!-- Já é professor, botão SIM desabilitado -->
                                                <button type="button" class="btn btn-success btn-sm" disabled>SIM</button>
                                            </td>
                                            <td>
                                                <!-- Tornar administrador -->
                                                <form method="POST" action="{{ route('administrador.edit', ['idnumIdentidade' => $professor->numIdentidade]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="nova_funcao" value="administrador">
                                                    <button type="submit" class="btn btn-danger btn-sm">NÃO</button>
                                                </form>
                                            </td>
                                        @endif
                                      
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Botão Salvar -->
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary">SALVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- resources/views/professor/certificadosRecebidos.blade.php --}}
@push('scripts')
    <script src="{{ asset('js/professor/professor.js') }}"></script>
@endpush

<div class="certificados-recebidos-box">
    <h2>CERTIFICADOS RECEBIDOS</h2>
    <div class="certificados-tabela-container">
        <div class="certificados-tabela-scroll">
            <table class="certificados-tabela">
                <thead>
                    <tr>
                        <th>ALUNO</th>
                        <th>TURMA</th>
                        <th>CATEGORIA</th>
                        <th>SUBCATEGORIA</th>
                        <th>ENVIO</th>
                        <th>STATUS</th>
                        <th>SEMESTRE</th>
                        <th>HORAS</th>
                        <th>ARQUIVO</th>
                        <th>APROVAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificados as $certificado)
                        <tr>
                            <form action="{{ route('certificados.atualizar', $certificado->idCertificado) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <td>{{ $certificado->name }}</td>
                                <td>{{ $certificado->turma }}</td>
                                <td>
                                    <select name="idTipoAtividade" required class="input-arredondado">
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->idTipoAtividade }}"
                                                {{ $certificado->tipo_atividade == $categoria->idTipoAtividade ? 'selected' : '' }}>
                                                {{ $categoria->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="idAtividadeComplementar" required class="input-arredondado">
                                        @foreach ($subcategorias as $sub)
                                            @if ($sub->idAtividadeComplementar == $certificado->idAtividadeComplementar)
                                                <option value="{{ $sub->idAtividadeComplementar }}"
                                                    {{ $certificado->idAtividadeComplementar == $sub->idAtividadeComplementar ? 'selected' : '' }}>
                                                    {{ $sub->nomeAtividadeComplementar }}
                                                </option>
                                            @else
                                            <option class="option" value="{{ $sub->idAtividadeComplementar }}"
                                                    {{ $certificado->idAtividadeComplementar == $sub->idAtividadeComplementar ? : '' }}>
                                                    {{ $sub->nomeAtividadeComplementar }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="date" name="dataEnvio" value="{{ $certificado->dataEnvio }}" class="input-arredondado">
                                </td>
                                <td>{{ $certificado->statusCertificado ?? '-' }}</td>
                                <td>
                                    <input type="text" name="semestre" value="{{ $certificado->semestre }}" >
                                </td>
                                <td>
                                    <input type="number" name="cargaHoraria" value="{{ $certificado->cargaHoraria }}"
                                        min="1" class="input-pequeno">
                                </td>
                                <td>
                                    <a href="{{ url('/certificados/visualizar/' . $certificado->idCertificado) }}"
                                        target="_blank">
                                        <img src="{{ asset('imagens/professor/download.ico') }}"
                                            alt="icone de download" class="download-icon" width="25">
                                    </a>
                                </td>
                                <td>
                                    <button type="submit" style="border: none; background: none; cursor: pointer;"
                                        onclick="return confirm('Qualquer alteração feita no certificado será aplicada. Deseja continuar?');">
                                        <img src="{{ asset('imagens/professor/like.ico') }}" alt="Editar"
                                            width="20">
                                    </button>

                                    <form style="display:inline;">
                                        <button type="button" class="btn-rejeitar"
                                            style="border: none; background: none; cursor: pointer;"
                                            data-action="{{ route('certificados.rejeitar', $certificado->idCertificado) }}"
                                            data-csrf="{{ csrf_token() }}">
                                            <img src="{{ asset('imagens/professor/reject.ico') }}" alt="Rejeitar"
                                                width="20">
                                        </button>
                                    </form>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </div>
</div>
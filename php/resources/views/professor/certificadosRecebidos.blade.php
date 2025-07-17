{{-- resources/views/professor/certificadosRecebidos.blade.php --}}
<div class="certificados-recebidos-box">
    <h1>CERTIFICADOS RECEBIDOS</h1>
    <div class="certificados-tabela-container">
        <table class="certificados-tabela">
            <thead>
                <tr>
                    <th>ALUNO</th>
                    <th>TURMA</th>
                    <th>CATEGORIA</th>
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
                        <td>{{ $certificado->name }}</td>
                        <td>{{ $certificado->turma }}</td>
                        <td>{{ $certificado->idAtividadeComplementar }}</td>
                        <td>{{ $certificado->dataEnvio }}</td>
                        <td>{{ $certificado->statusCertificado ?? '-' }}</td>
                        <td>{{ $certificado->semestre }}</td>
                        <td>{{ $certificado->cargaHoraria }}</td>
                        <td>
                            <a href="{{ url('/certificados/visualizar/' . $certificado->idCertificado) }}"
                                target="_blank">
                                <img src="{{ asset('imagens/professor/download.ico') }}" alt="icone de download"
                                    class="download-icon" width="25">
                            </a>
                        </td>

                        <td>
                            <!-- Rejeitar -->
                            <form action="{{ route('certificados.rejeitar', $certificado->idCertificado) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="border: none; background: none; cursor: pointer;">
                                    <img src="{{ asset('imagens/professor/reject.ico') }}" alt="Rejeitar"
                                        width="20">
                                </button>
                            </form>

                            <!-- Editar -->
                            <a href="{{ route('certificados.editar', $certificado->idCertificado) }}">
                                <img src="{{ asset('imagens/professor/edit.ico') }}" alt="Editar" width="20">
                            </a>

                            <!-- Aprovar -->
                            <form action="{{ route('certificados.aprovar', $certificado->idCertificado) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="border: none; background: none; cursor: pointer;">
                                    <img src="{{ asset('imagens/professor/like.ico') }}" alt="Aprovar" width="20">
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

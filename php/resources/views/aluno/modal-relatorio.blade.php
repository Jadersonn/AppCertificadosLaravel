<link rel="stylesheet" href="/css/layouts/modal-relatorio.css">

<div class="painel-categoria-header">
    <span class="painel-categoria-titulo">{{ $categoriaNome ?? 'Categoria' }}</span>
</div>
<table class="painel-categoria-tabela" >
    <thead>
        <tr>
            <th>CATEGORIAS</th>
            <th>ATIVIDADES</th>
            <th>CARGA HORÁRIA</th>
            <th>PONTOS</th>
            <th>DATA ENVIO</th>
            <th>STATUS</th>
            <th>JUSTIFICATIVA</th>
            <th>PROFESSOR</th>
            <th>SEMESTRE</th>
            <th>BAIXAR</th>
        </tr>
    </thead>
    <tbody>
        @forelse($certificados as $certificado)
            <tr>
                <td>{{ $certificado->categoria ?? '-' }}</td>
                <td>{{ $certificado->atividade ?? '-' }}</td>
                <td>{{ $certificado->cargaHoraria ?? '-' }}</td>
                <td>{{ $certificado->pontosGerados ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($certificado->dataEnvio)->format('d/m/Y') }}</td>
                <td>{{ $certificado->statusCertificado ?? '-' }}</td>
                <td>{{ $certificado->justificativa ?? '-' }}</td>
                <td>{{ $certificado->nomeProfessor ?? '-' }}</td>
                <td>{{ $certificado->semestre ?? '-' }}</td>
                <td>
                    @if (!empty($certificado->idCertificado))
                        <a class="link" href="{{  url('/certificados/visualizar/' . $certificado->idCertificado) }}" target="_blank">
                            <button>Baixar</button>
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center;">Nenhuma solicitação encontrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>

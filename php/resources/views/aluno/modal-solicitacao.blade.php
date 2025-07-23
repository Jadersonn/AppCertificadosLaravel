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
                        <option value="" disabled selected>Selecione uma categoria</option>
                        @foreach ($tiposAtividades as $index => $tipo)
                            <option value="{{ $tipo->idTipoAtividade }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-col">
                    <label for="subcategoria">Subcategoria</label>
                    @if ($subCategorias->isNotEmpty())
                        <select id="subcategoria" name="subcategoria" required>
                            <option value="" disabled selected>Selecione uma subcategoria</option>
                            @foreach ($subCategorias as $index => $tipo)
                                <option value="{{ $tipo->idAtividadeComplementar }}">
                                    {{ $tipo->nomeAtividadeComplementar }}</option>
                            @endforeach
                        </select>
                    @endif
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
                <div class="modal-col" style="position:relative;">
                    <label for="horas">Horas</label>
                    <input type="number" id="horas" name="horas" placeholder="Horas" required min="1"
                        onfocus="document.getElementById('tooltip-horas').style.display='block'"
                        onblur="document.getElementById('tooltip-horas').style.display='none'">
                    <span id="tooltip-horas" style="
                        display:none;
                        position:absolute;
                        left:0;
                        top:65px;
                        background:#f8f9fa;
                        color:#333;
                        border:1px solid #ccc;
                        border-radius:4px;
                        padding:8px 12px;
                        font-size:13px;
                        z-index:10;
                        box-shadow:0 2px 8px rgba(0,0,0,0.08);
                        width:260px;
                    ">
                        Envie uma atividade por vez.<br>
                        Em caso de atividades contabilizadas por mês, envie a quantidade de meses.
                    </span>
                </div>
            </div>
            <div style="margin-bottom: 1em;">
                <label for="arquivo">Arquivo:</label>
                <div class="input-arquivo-wrapper">
                    <input type="file" id="arquivo" name="arquivo" accept="application/pdf" required>
                    <label for="arquivo" id="arquivo-label">
                        <span id="arquivo-status"><span class="arquivo-mais">+</span><br><span
                                class="arquivo-texto">Selecione um PDF</span></span><span class="arquivo-texto">Até
                            30MB</span>
                    </label>
                </div>
            </div>
            <div style="text-align: right;">
                <button type="submit" class="modal-enviar">Enviar</button>
            </div>
        </form>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificados de Aluno</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/base.css') }}">
    @stack('head')
</head>

<body>
    @if (session('success'))
        <script>
            alert(@json(session('success')));
        </script>
    @endif

    @if (session('error'))
        <script>
            alert(@json(session('error')));
        </script>
    @endif
    <div class="container">
        <div class="login-box">
            <div class="left-panel">
                <div class="logo">
                    <a href="{{ route('aluno') }}">
                        <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
                    </a>
                </div>
                <nav class="menu mt-4">
                    <ul>
                        <li><a href="https://academico.ifms.edu.br" class="menu-btn" target="_blank">Sistema
                                acadêmico</a></li>
                        <li><a href="https://ead.ifms.edu.br" class="menu-btn" target="_blank">EAD - Moodle</a></li>
                        <li><a href="https://ifms.edu.br" class="menu-btn" target="_blank">Site IFMS</a></li>
                    </ul>
                </nav>
                <!-- classe de logout-->
                <div class="logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Sair</button>
                    </form>

                </div>
                <div>
                </div>
            </div>
            <div class="saudacao">
                Oi, {{ Auth::user()->name }}
                <div class="categorias-container">
                    @foreach ($tiposAtividades as $index => $tipo)
                        @php
                            // Busca o ponto da categoria, se existir
                            $ponto = $pontos->firstWhere('idTipoAtividade', $tipo->idTipoAtividade);
                            $percentual = $ponto ? $ponto->totalPontos : 0; // Usa o totalPontos retornado pelo select
                        @endphp

                        <div class="categoria-box"
                            style="top: {{ 83 + $index * 110 }}px;"
                            data-bs-toggle="modal"
                            data-bs-target="#categoriaModal"
                            data-tipo-id="{{ $tipo->idTipoAtividade }}"
                            data-user-id="{{ Auth::user()->id }}">
                            {{ $tipo->nome }}
                        </div>
                        <!-- barra de progresso -->
                        <div class="progress-bar" style="top: {{ 140 + $index * 110 }}px;">
                            <div class="progress-inner" id="progressBar-{{ $index }}" role="progressbar"
                                style="width: {{ $percentual }}%; padding-left: 10px;"
                                aria-valuenow="{{ $percentual }}" aria-valuemin="0"
                                aria-valuemax="{{ $aluno->pontosRecebidos }}">
                                {{ $percentual }} Pontos
                            </div>
                        </div>

                        <button class="enviar-btn" id="enviar-btn-{{ $index }}"
                            style="top: {{ 100 + $index * 110 }}px;">Enviar
                        </button>
                    @endforeach


                    <div class="titulo-categorias">CATEGORIAS</div>
                    <div class="titulo-geral">GERAL</div>
                </div>
            </div>

            <div class="right-panel">
                @yield('right-panel')
            </div>

        </div>
    </div>
    @include('aluno.modal-solicitacao')

    <div id="modal-relatorio" class="modal-relatorio" style="display: none;">
        <div class="modal-conteudo">
            <button class="modal-fechar" id="fechar-modal-relatorio">×</button>
            <h2 style="margin-bottom: 1.2em;" >Relatorio de Categoria</h2>
            <div class="painel-categoria">
                <!-- Aqui o JS vai inserir o conteúdo AJAX -->
            </div>
        </div>
    </div>
</body>

</html>

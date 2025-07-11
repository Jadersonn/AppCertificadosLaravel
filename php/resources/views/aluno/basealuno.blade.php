<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">    
    <link rel="stylesheet" href="{{ asset('css/layouts/base.css') }}">
    @stack('head')
</head>

<body>
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
                        <div class="categoria-box" style="top: {{ 83 + $index * 110 }}px;">
                            {{ $tipo->nome }}
                        </div>
                        <div class="progress-bar" style="top: {{ 140 + $index * 110 }}px;">
                            <div class="progress-inner" id="progressBar-{{ $index }}" role="progressbar"
                                style="width: {{ $tipo->percentual }}%;" aria-valuenow="{{ $tipo->percentual }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $tipo->percentual }}%
                            </div>
                        </div>
                        <button class="enviar-btn" id="enviar-btn-{{ $index }}"
                            style="top: {{ 100 + $index * 110 }}px;">Enviar
                        </button>
                    @endforeach


                    <div class="titulo-categorias">CATEGORIAS</div>
                    <select class="titulo-geral-select">
                        <option value="geral" selected>GERAL</option>
                        @foreach ($tiposAtividades as $tipo)
                            <option value="{{ $tipo->idTipoAtividade }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="right-panel">
                @yield('right-panel')
            </div>

        </div>
    </div>
    @include('aluno.modal-solicitacao')
    @include('aluno.modal-relatorio')
</body>

</html>

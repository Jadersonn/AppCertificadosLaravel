<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Certificados IFMS') }}</title>
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
                    <div class="categoria-box" style="top: 83px;">Categoria 1</div>
                    <div class="progress-bar" style="top: 140px;">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                    <button class="enviar-btn" style="top: 100px;">Enviar</button>

                    <div class="categoria-box" style="top: 183px;">Categoria 2</div>
                    <div class="progress-bar" style="top: 240px;">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 60%;" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100">60%</div>
                    </div>
                    <button class="enviar-btn" style="top: 200px;">Enviar</button>

                    <div class="categoria-box" style="top: 283px;">Categoria 3</div>
                    <div class="progress-bar" style="top: 340px;">
                        <div class="progress-bar" role="progressbar" id="progressBar" style="width: 80%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                    <button class="enviar-btn" style="top: 300px;">Enviar</button>

                    <div class="categoria-box" style="top: 383px;">Categoria 4</div>
                    <div class="progress-bar" style="top: 440px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                    <button class="enviar-btn" style="top: 400px;">Enviar</button>

                    <div class="titulo-categorias">CATEGORIAS</div>
                    <select class="titulo-geral-select">
                        <option value="geral" selected>GERAL</option>
                        <option value="categoria1">Categoria 1</option>
                        <option value="categoria2">Categoria 2</option>
                        <option value="categoria3">Categoria 3</option>
                        <option value="categoria4">Categoria 4</option>
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

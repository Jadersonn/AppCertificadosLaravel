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
                    <div class="categoria-box" style="top: 196px;">Categoria 2</div>
                    <div class="categoria-box" style="top: 309px;">Categoria 3</div>
                    <div class="categoria-box" style="top: 422px;">Categoria 4</div>

                    <div class="barra barra1" style="top: 137px;"></div>
                    <div class="barra barra2" style="top: 249px;"></div>
                    <div class="barra barra3" style="top: 365px;"></div>
                    <div class="barra barra4" style="top: 475px;"></div>

                    <div class="status status1" style="top: 137px;">50%</div>
                    <div class="status status2" style="top: 249px;">90%</div>
                    <div class="status status3" style="top: 365px;">0%</div>
                    <div class="status status4" style="top: 475px; color: #003C0B;">Concluído</div>

                    <button class="enviar-btn" style="top: 98px;">Enviar</button>
                    <button class="enviar-btn" style="top: 208px;">Enviar</button>
                    <button class="enviar-btn" style="top: 324px;">Enviar</button>
                    <button class="enviar-btn" style="top: 438px;">Enviar</button>

                    <div class="titulo-categorias">CATEGORIAS</div>
                    <div class="titulo-geral">GERAL</div>
                </div>
            </div>

            <div class="right-panel">
                @yield('right-panel')
            </div>

        </div>
    </div>
</body>

</html>

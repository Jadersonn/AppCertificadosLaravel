<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Certificados IFMS') }}</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/base.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('head')
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="left-panel">
                <div class="logo">
                    <a href="{{ route('administrador') }}">
                        <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
                    </a>
                </div>
                <nav class="menu mt-4">
                    <ul>
                        <li><a href="https://academico.ifms.edu.br" class="menu-btn" target="_blank">Sistemas IFMS</a></li>
                        <li><a href="https://ead.ifms.edu.br" class="menu-btn" target="_blank">EAD - Moodle</a></li>
                        <li><a href="#" class="menu-btn" target="_blank">Regulamento</a></li>
                        <li><a href="#" class="menu-btn" data-bs-toggle="modal" data-bs-target="#turmaModal">Definir Turma</a></li>
                        <li><a href="#" class="menu-btn" data-bs-toggle="modal" data-bs-target="#responsavelModal">Definir Responsável</a></li>
                    </ul>
                </nav>
                <div class="logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Sair</button>
                    </form>
                </div>
            </div>
            <div class="main-panel">
                @yield('main')
            </div>
            <div class="container-admin">
                <div class="tabela-recebidos">
                    <h1>PAINEL DO ADMINISTRADOR</h1>
                    <div class="tabela-container">
                        <table class="admin-tabela">
                            <thead>
                                <tr>
                                    <th>CURSO</th>
                                    <th>RESPONSÁVEL</th>
                                    <th>IDENTIFICAÇÃO</th>
                                    <th>PERÍODO</th>
                                    <th>HISTÓRICO</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tabela-recebidos">
                    <h1>HISTÓRICO DE CERTIFICADOS</h1>
                    <div class="tabela-container">
                        <table class="admin-tabela">
                            <thead>
                                <tr>
                                    <th>ALUNO</th>
                                    <th>PROFESSOR</th>
                                    <th>TURMA</th>
                                    <th>PONTO</th>
                                    <th>CATEGORIA</th>
                                    <th>CERTIFICADO</th>
                                    <th>DATA ENVIO</th>
                                    <th>CARGA HORÁRIA</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="right-panel">
                @yield('right-panel')
            </div>
        </div>
    </div>

    <!-- Modais -->
    @include('administrador.modal-definirTurma')
    @include('administrador.modal-definirResponsavel')

    <!-- Bootstrap JS Bundle (Popper incluído) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

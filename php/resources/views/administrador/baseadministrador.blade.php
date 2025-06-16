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
          <a href="{{route('administrador')}}">
            <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
          </a>
        </div>
        <nav class="menu mt-4">
          <ul>
            <li><a href="https://academico.ifms.edu.br" class="menu-btn" target="_blank">Sistemas IFMS</a></li>
            <li><a href="https://ead.ifms.edu.br" class="menu-btn" target="_blank">EAD - Moodle</a></li>
            <li><a href="#" class="menu-btn" target="_blank">Regulamento</a></li>
            <li><a href="#" class="menu-btn" target="_blank">Definir Turma</a></li>
            <li><a href="#" class="menu-btn" target="_blank">Definir Responsável</a></li>

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
                {{-- Linhas de exemplo, pode preencher dinamicamente --}}
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
                {{-- Linhas de exemplo, pode preencher dinamicamente --}}
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
</body>

</html>
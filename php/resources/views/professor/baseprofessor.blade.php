<!DOCTYPE html>
<html lang="en">
@stack('scripts')
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
          <a href="{{route('professor')}}">
            <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
          </a>
        </div>
        <nav class="menu mt-4">
          <ul>
            <li><a href="https://academico.ifms.edu.br" class="menu-btn" target="_blank">Sistema IFMS</a></li>
            <li><a href="https://ead.ifms.edu.br" class="menu-btn" target="_blank">EAD - Moodle</a></li>
            <li><a href="#" class="menu-btn" target="_blank">Regulamento de Carga Horária</a></li>

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

    </div>
  </div>
</body>

</html>
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
          <a href="{{ route('login') }}">
            <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
          </a>
        </div>
         <nav class="menu mt-4">
      <ul>
        <li><a href="#" class="menu-btn">Sistema acadêmico</a></li>
        <li><a href="#" class="menu-btn">EAD - Moodle</a></li>
        <li><a href="#" class="menu-btn">Site IFMS</a></li>
      </ul>
    </nav>
     <div class="logout">
        <button type="button" class="logout-btn">Sair</button>
    </div>
      </div>
      <div class="right-panel">
       @yield('content')
        <div class="footer">
          Em caso de problemas para acesso ao sistema entre<br> em contato com a CEREL<br><br>
          2025 © Jaderson Pillar e Lara Riomayor
        </div>
      </div>
    </div>
  </div>
</body>
</html>
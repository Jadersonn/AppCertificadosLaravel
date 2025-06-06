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
          <a href="route('logout')">
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
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Sair</button>
    </form>
</div>
      </div>
      <div class="right-panel">
       @yield('content')
      </div>
    </div>
  </div>
</body>
</html>
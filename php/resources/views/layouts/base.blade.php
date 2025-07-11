<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.name', 'Certificados IFMS') }}</title>
  <link rel="stylesheet" href="{{ asset('css/layouts/base.css') }}">
  <link rel="icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
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
        <div class="title">HORAS<br>COMPLEMENTARES</div>
      </div>
      <div class="right-panel">
        {{ $slot }}
        <div class="footer">
          Em caso de problemas para acesso ao sistema entre<br> em contato com a CEREL<br><br>
          2025 © Jaderson Pillar e Lara Riomayor
        </div>
      </div>
    </div>
  </div>
</body>
</html>
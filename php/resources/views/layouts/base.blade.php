<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <title>{{ config('app.name', 'Certificados IFMS') }}</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #00722d;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh;
    }
    .login-box {
      background-color: white;
      border-radius: 8px;
      display: flex;
      width: 800px;
      box-shadow: 0 0 100px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }
    .left-panel {
      background-color: #00420C;
      color: white;
      padding: 30px 20px;
      text-align: center;
      width: 250px;
      align-items: center;
    }
    .left-panel .logo {
      width: 80px;
      height: auto;
      display: block;
      font-size: 40px;
      margin: 0 auto;
    }
    .left-panel .title {
      font-weight: bold;
      margin-top: 35%;
      font-size: 20px;
    }
    .right-panel {
      flex: 1;
      padding: 50px;
    }
    h1 {
      text-align: center;
      color: #00420C;
    }
    p {
      text-align: center;
      color: #555;
    }
    div.title {
      margin-top: 50%;
    }
    .form-group {
      margin: 20px 0;
    }
    input[type="text"],
    input[type="password"] 
    {
      width: 100%;
      padding: 12px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    .forgot-password {
      text-align: right;
      font-size: 12px;
      margin-top: 8px;
    }
    .login-button {
      width: 200%;
      background-color: #00420C;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;

      display: block;
      margin: 20px auto 0 auto;
    }
    .footer {
      text-align: center;
      font-size: 11px;
      color: #666;
      margin-top: 40px;
    }
  </style>
  @stack('head')
</head>
<body>
      <div class="container">
    <div class="login-box">
      <div class="left-panel">
        <div class="logo">
          <img src="{{ asset('imagens/logoIF.png') }}" alt="logo" class="logo">
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
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Certificados IFMS</title>
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
      height: 100vh;
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
      padding: 40px 20px;
      text-align: center;
      width: 250px;
    }

    .left-panel .logo {
      font-size: 40px;
      margin-bottom: 20px;
    }

    .left-panel .title {
      font-weight: bold;
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
    input[type="password"] {
      width: 94%;
      padding: 12px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .forgot-password {
      text-align: right;
      font-size: 12px;
      margin-top: 8px;
    }

    .login-button {
      width: 100%;
      background-color: #00420C;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .footer {
      text-align: center;
      font-size: 11px;
      color: #666;
      margin-top: 30px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-box">
      <div class="left-panel">
        <div class="logo">🟩</div>
        <div class="title">HORAS<br>COMPLEMENTARES</div>
      </div>
      <div class="right-panel">
        <h1>LOGIN</h1>
        <p>Entre com seus dados institucionais</p>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group" x-data>
            <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" required x-mask="999.999.999-99"
              placeholder="CPF" />
            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
          </div>
          <div class="form-group">
            <div class="mt-4">

              <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" placeholder="SENHA" />

              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <a href="{{url('resetSenha')}}">
              <div class="forgot-password">Esqueci minha senha</div>
            </a>
          </div>
          <button class="login-button" type="submit">{{ __('ENTRAR') }}</button>
        </form>
        <div class="footer">
          Em caso de problemas para acesso ao sistema entre<br> em contato com a CEREL<br><br>
          2025 © Jaderson Pillar e Lara Riomayor
        </div>
      </div>
    </div>
  </div>
</body>

</html>
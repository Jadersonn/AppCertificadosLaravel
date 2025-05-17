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
      text-align: left;
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
      margin-top: 5px;
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
    .forgot-password{
      text-align: right;
      font-size: 12px;
      margin: 3px;
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
        <p>Informe seu email:</p>
        <form>
          <div class="form-group">
            <input type="text" placeholder="EMAIL">
          </div>
          <div class="forgot-password">
            <a href="{{ route('login') }}">Ja tem conta?</a>
          </div>
          <button class="login-button" type="submit">ENVIAR</button>
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
# Sistema de Certificados IFMS

Este é um sistema web para gerenciamento e emissão de certificados acadêmicos, desenvolvido em Laravel. O objetivo é facilitar o controle de horas complementares de alunos, com área para professores e administradores.

---

## 🚀 Instalação Rápida

1. **Clone o projeto**
   git clone https://github.com/Jadersonn/AppCertificadosLaravel
   cd AppCertificadosLaravel/php

2. **Instale as dependências** 
    composer install
    npm install
    npm run build

3. **Configure seu ambiente** 
    Copie o arquivo .env.example para .env
    Edite o .env e ajuste:
        Dados do banco de dados (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
    Caminho para salvar certificados:
    ENDERECO_CERTIFICADOS=/caminho/para/salvar/certificados
    (No Windows, use o caminho completo, ex: C:\Users\SeuUsuario\certificados)

4. **Gere a chave da aplicação** 
    php artisan key:generate

5. **Rode as migrations e seeders**
    php artisan migrate --seed

6. **Inicie o servidor**
    php artisan serve

Acesse em http://localhost:8000

👤 Usuários de Teste
Administrador:
Email: admin@example.com
Senha: senha123

Professor:
Email: professor@example.com
Senha: senha123

Aluno:
Email: aluno@example.com
Senha: senha123

💡 Sobre o Projeto
Tecnologias: Laravel, MySQL, TailwindCSS, JavaScript
Funcionalidades:
Cadastro e login de usuários (aluno, professor, admin)
Envio e validação de certificados em PDF
Aprovação/reprovação de certificados por professores
Relatórios e painel administrativo

📄 Observações
O sistema foi desenvolvido como projeto para o Instituto Federal de Mato Grosso do Sul - Campus Corumbá.
O código está documentado e organizado para fácil entendimento.
Qualquer dúvida, entre em contato!

Desenvolvido por Jaderson Pillar e Lara Riomayor

pillar.jaderson@gmail.com
---

# 🎓 Sistema de Certificados IFMS

Sistema web desenvolvido em **Laravel** para o gerenciamento e emissão de certificados acadêmicos, com foco no controle de **atividades complementares dos alunos** e áreas exclusivas para **professores** e **administradores**.

---

## 🚀 Instalação Rápida

### 1. Clone o projeto:

```bash
git clone https://github.com/Jadersonn/AppCertificadosLaravel
cd AppCertificadosLaravel/php
```

### 2. Instale as dependências:

```bash
composer install
npm install
npm run build
```

### 3. Configure o ambiente:

* Copie o arquivo `.env.example` e renomeie:

```bash
cp .env.example .env
```

* Edite o arquivo `.env` com seus dados de banco:

```
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

* Configure o caminho para salvar os certificados:

```
ENDERECO_CERTIFICADOS=/caminho/para/salvar/certificados
```

> ⚠️ No Windows, use o caminho completo, como:
> `C:\Users\SeuUsuario\certificados`

### 4. Gere a chave da aplicação:

```bash
php artisan key:generate
```

### 5. Rode as migrations e seeders:

```bash
php artisan migrate --seed
```

### 6. Inicie o servidor:

```bash
php artisan serve
```

📍 Acesse: [http://localhost:8000](http://localhost:8000)

---

## 👤 Usuários de Teste

| Função        | E-mail                                                | Senha    |
| ------------- | ----------------------------------------------------- | -------- |
| Administrador | [admin@example.com](mailto:admin@example.com)         | senha123 |
| Professor     | [professor@example.com](mailto:professor@example.com) | senha123 |
| Aluno         | [aluno@example.com](mailto:aluno@example.com)         | senha123 |

---

## 💡 Sobre o Projeto

**Tecnologias utilizadas**:

* PHP / Laravel
* MySQL
* Tailwind CSS
* Alpine.js
* Vite
* JavaScript

**Funcionalidades**:

* Cadastro e login com autenticação
* Upload de certificados em PDF
* Validação e reprovação de certificados pelos professores
* Acompanhamento de carga horária pelos alunos
* Geração de relatórios completos para gestão acadêmica

---

## 🏫 Instituição

Este projeto foi desenvolvido como parte de uma iniciativa acadêmica no
**Instituto Federal de Mato Grosso do Sul – Campus Corumbá**.

---

## 👨‍💻 Desenvolvedores

* Jaderson Pillar
* Lara Riomayor

📩 Contato: [pillar.jaderson@gmail.com](mailto:pillar.jaderson@gmail.com) 
📩 Contato: [riomayorlara@gmail.com](mailto:riomayorlara@gmail.com)

---

# 🏥 Secretaria Municipal de Saúde — Guarapuava

Site oficial da Secretaria Municipal de Saúde de Guarapuava,
desenvolvido com Flask + Jinja2 + CSS modular.

---

## 📋 Índice

- [Tecnologias](#-tecnologias)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Pré-requisitos](#-pré-requisitos)
- [Instalação](#-instalação)
- [Variáveis de Ambiente](#-variáveis-de-ambiente)
- [Como Rodar](#-como-rodar)
- [Rodando no Servidor Ubuntu](#-rodando-no-servidor-ubuntu)
- [Configuração de E-mail](#-configuração-de-e-mail)
- [Segurança](#-segurança)

---

## 🚀 Tecnologias

- [Python 3.x](https://www.python.org/)
- [Flask 3.0](https://flask.palletsprojects.com/)
- [Flask-Mail](https://pythonhosted.org/Flask-Mail/)
- [Flask-WTF](https://flask-wtf.readthedocs.io/)
- [Bleach](https://bleach.readthedocs.io/)
- [Jinja2 Templates](https://jinja.palletsprojects.com/)
- [Font Awesome 6](https://fontawesome.com/)
- [Google Fonts — Poppins](https://fonts.google.com/specimen/Poppins)

## 📁 Estrutura do Projeto

projeto/
│
├── app.py
├── requirements.txt
├── .env                          
├── .gitignore
├── README.md
│
├── templates/
│   ├── index.html
│   └── sections/
│       ├── navbar.html
│       ├── hero.html
│       ├── sobre.html
│       ├── servicos.html
│       ├── departamentos.html
│       ├── noticias.html
│       ├── contato.html
│       └── footer.html
│
└── static/
    ├── css/
    │   ├── style.css             ← Importa todos os CSS
    │   ├── base.css
    │   ├── navbar.css
    │   ├── hero.css
    │   ├── sobre.css
    │   ├── servicos.css
    │   ├── departamentos.css     ← Inclui carousel e modal
    │   ├── noticias.css
    │   ├── contato.css
    │   ├── footer.css
    │   └── responsive.css
    ├── js/
    │   └── main.js
    └── images/
        ├── brasao.png
        └── hero.png

---

## ⚙️ Pré-requisitos

Antes de começar, você precisa ter instalado:

- [Python 3.10+](https://www.python.org/downloads/)
- [Git](https://git-scm.com/)
- Pip (já vem com o Python)

---

## 💻 Instalação

### 1. Clone o repositório
DE um Git clone a partir do repositório atual


### 2. Crie o ambiente virtual

# Linux / Ubuntu
python3 -m venv venv
source venv/bin/activate

# Windows
python -m venv venv
venv\Scripts\activate

### 3. Instale as dependências
pip install -r requirements.txt

## 🔐 Variáveis de Ambiente
crie o arquivo a partir do .env-example e preencha com os dados que irão ser usados

### Como gerar uma SECRET_KEY segura:
python -c "import secrets; print(secrets.token_hex(32))"

## ▶️ Como Rodar

### Windows (desenvolvimento)

# Ative o ambiente virtual
venv\Scripts\activate

# Carregue as variáveis de ambiente
set SECRET_KEY=sua-chave-secreta
set MAIL_USERNAME=seuemail@gmail.com
set MAIL_PASSWORD=sua-senha-de-app
set EMAIL_SECRETARIA=email@gmail.com

# Rode o servidor
python app.py

Acesse em: **http://localhost:5000**



### Linux / Ubuntu (desenvolvimento)
# Ative o ambiente virtual
source venv/bin/activate

# Carregue as variáveis de ambiente
export $(cat .env | xargs)

# Rode o servidor
python app.py

Acesse em: **http://localhost:5000**

## 🖥️ Rodando no Servidor Ubuntu

### 1. Atualize o sistema e instale dependências

sudo apt update
sudo apt install python3-pip python3-venv -y

### 2. Clone e configure o projeto
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt

### 3. Configure o arquivo .env
cp .env-example .env
nano .env

### 4. Libere a porta no firewall(Caso seja necessario)
sudo ufw allow 5000
sudo ufw status

### 5. Rode o servidor
# Carrega as variáveis e sobe o servidor
export $(cat .env | xargs)
python app.py

Acesse em: http://seu-ip-local:5000

### 🔄 Manter o servidor rodando em background
# Instale o screen
sudo apt install screen -y

# Crie uma sessão
screen -S saude

# Suba o servidor dentro da sessão
export $(cat .env | xargs)
python app.py

# Para sair sem encerrar: Ctrl+A depois D
# Para voltar à sessão:
screen -r saude


## 📧 Configuração de E-mail (Gmail)

O projeto usa Gmail com **Senha de App** para envio de e-mails.

### Como gerar a Senha de App:

Acesse: myaccount.google.com
Segurança → Verificação em duas etapas (ative se necessário)
Segurança → Senhas de app
Selecione "Outro" e nomeie como "Flask Saude"
Copie a senha gerada (16 caracteres)
Cole no MAIL_PASSWORD do arquivo .env
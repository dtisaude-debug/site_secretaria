import os
import requests
import bleach
from datetime import datetime
from waitress import serve
from flask import Flask, render_template, request, jsonify
from flask_mail import Mail, Message
from flask_wtf.csrf import CSRFProtect
from dotenv import load_dotenv

load_dotenv()

app = Flask(__name__)
app.config['SECRET_KEY'] = os.environ.get('SECRET_KEY', 'troque-por-chave-segura')

csrf = CSRFProtect(app)

# =============================================
# Configuração de e-mail
# =============================================
app.config['MAIL_SERVER']         = 'smtp.gmail.com'
app.config['MAIL_PORT']           = 587
app.config['MAIL_USE_TLS']        = True
app.config['MAIL_USERNAME']       = os.environ.get('MAIL_USERNAME')
app.config['MAIL_PASSWORD']       = os.environ.get('MAIL_PASSWORD')
app.config['MAIL_DEFAULT_SENDER'] = os.environ.get('MAIL_USERNAME')

mail = Mail(app)

EMAIL_SECRETARIA = os.environ.get('EMAIL_SECRETARIA', 'secretaria@guarapuava.pr.gov.br')

# ← URL da API do Laravel
LARAVEL_API_URL = os.environ.get('LARAVEL_API_URL', 'http://localhost:8000/api')

# =============================================
# Função para buscar notícias
# =============================================

def buscar_noticias() -> list:
    """Busca notícias publicadas na API do Laravel."""
    try:
        response = requests.get(
            f'{LARAVEL_API_URL}/noticias',
            timeout=5
        )
        if response.status_code == 200:
            noticias = response.json()
            # Sanitiza o conteúdo vindo da API
            for noticia in noticias:
                noticia['titulo']    = bleach.clean(noticia['titulo'])
                noticia['resumo']    = bleach.clean(noticia['resumo'])
                noticia['categoria'] = bleach.clean(noticia['categoria'])
            return noticias
    except requests.exceptions.RequestException as e:
        print(f'[WARN] API Laravel indisponível: {e}')
    return []

# =============================================
# Rotas
# =============================================

@app.route('/')
def index():
    noticias = buscar_noticias()             
    return render_template('index.html',
                           noticias=noticias,           
                           ano=datetime.now().year)     


@app.route('/enviar-contato', methods=['POST'])
def enviar_contato():
    # ... seu código já existente, sem alterações ...
    try:
        data = request.get_json()

        nome     = bleach.clean(data.get('nome',     '').strip())
        email    = bleach.clean(data.get('email',    '').strip())
        mensagem = bleach.clean(data.get('mensagem', '').strip())

        if not nome or not email or not mensagem:
            return jsonify({'success': False, 'message': 'Preencha todos os campos.'}), 400

        if len(nome) > 100 or len(mensagem) > 2000:
            return jsonify({'success': False, 'message': 'Dados excedem o tamanho permitido.'}), 400

        if '@' not in email or '.' not in email:
            return jsonify({'success': False, 'message': 'E-mail inválido.'}), 400

        msg = Message(
            subject    = f'[Contato Site] Mensagem de {nome}',
            recipients = [EMAIL_SECRETARIA],
            reply_to   = email,
            body = f"""
Nova mensagem recebida pelo site da Secretaria de Saúde.

─────────────────────────────
Nome:     {nome}
E-mail:   {email}
─────────────────────────────

Mensagem:
{mensagem}

─────────────────────────────
Mensagem enviada pelo site oficial.
            """
        )
        mail.send(msg)

        return jsonify({'success': True, 'message': f'Obrigado, {nome}! Sua mensagem foi enviada.'})

    except Exception as e:
        print(f'[ERRO] Envio de e-mail: {e}')
        return jsonify({'success': False, 'message': 'Erro ao enviar. Tente novamente.'}), 500



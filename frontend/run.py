from waitress import serve
from app import app

if __name__ == '__main__':
    try:
        print("Iniciando o servidor...")
        serve(app, host='127.0.0.1', port=5000, threads=4,)
        
    except Exception as e:
        print(f"Erro ao iniciar o servidor: {e}")
        print("Falha ao iniciar o servidor.")
